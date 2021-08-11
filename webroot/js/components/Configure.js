class Configure extends React.Component {
  constructor(props) {
    super(props);

    let selectedFilters = {};

    props.system['buckets'].forEach(bucket => {
      let bucketFilters = {};

      Object.entries(bucket['filters']).forEach(([name, options]) => {
        bucketFilters[name] = Object.values(options)[0];
      })

      selectedFilters[bucket['id']] = bucketFilters;
    });

    this.state = {
      system: props.system,
      currentTab: 0,
      currentConfig: props.currentConfig,
      selectedFilters: selectedFilters,
      compareProductHTML: undefined,
      errors: [],
      warnings: [],
      additionalItems: [],
    };
  }

  _getBucketImage(bucketID) {
    let itemsInBucket = this.state.currentConfig[bucketID];
    let lastSelectedItem = itemsInBucket.filter(item => item['selected_at']).sort((a, b) => a['selected_at'] - b['selected_at']).pop()

    if (lastSelectedItem) {
      return lastSelectedItem['image'];
    }

    let firstItemInBucket = itemsInBucket[0];

    return firstItemInBucket['image'];
  }

  _getBucketGroupImage(bucketID, groupIndex) {
    let groupItems = this.state.system['buckets'].filter(bucket => bucket['id'] === bucketID)[0]['groups'][groupIndex]['group_items'];
    let lastSelectedItemInGroup = groupItems.filter(item => item['selected_at']).sort((a, b) => a['selected_at'] - b['selected_at']).pop()

    if (lastSelectedItemInGroup) {
      return lastSelectedItemInGroup['image'];
    }

    let firstItemInBucket = groupItems[0];

    return firstItemInBucket['image'];
  }

  _clearFilters(bucketID) {
    let filters = this.state.selectedFilters;
    for (const filterGroup in filters[bucketID]) {
      filters[bucketID][filterGroup] = 'All';
    }

    this.setState({
      selectedFilters: filters,
    });
  }

  _changeTab(newTab) {
    this.setState({
      currentTab: newTab,
    });
  }

  _sendConfiguration(newConfig) {
    let system = Object.assign({}, this.state.system);
    this.props.validateConfiguration(this.state.system, newConfig, (result) => {
      system['price'] = result['price'];
      if ('cost' in result) {
        system['cost'] = result['cost'];
      }
      let validConfiguration = result['errors'].length === 0;

      this.setState({
        currentConfig: newConfig,
        system: system,
        warnings: result['warnings'],
        errors: result['errors'],
        additionalItems: result['additionalItems'],
      }, () => {
        this.props.updateSystem(system, validConfiguration);
      });
    })
  }

  _selectItem(bucketID, itemIndexInBucket) {
    let newConfig = Object.assign({}, this.state.currentConfig);
    let item = newConfig[bucketID][itemIndexInBucket];
    let bucket = this.state.system['buckets'].find(bucket => bucket['id'] === bucketID);

    if (bucket['multiple']) {
      let itemsInBucket = this.state.currentConfig[bucket['id']];
      let selectedItemsInBucket = itemsInBucket.filter(item => item['selected_at']);
      let bucketQuantity = selectedItemsInBucket.reduce((a, b) => a + b['quantity'], 0);
      let reachedMaxQuantity = bucket['maxqty'] == null ? false : bucketQuantity >= bucket['maxqty'];

      if (!item['selected_at'] && reachedMaxQuantity) {
        return;
      }

      item['selected_at'] = item['selected_at'] ? null : Date.now();
    } else {
      newConfig[bucketID].forEach((item, index) => {
        item['selected_at'] = index === itemIndexInBucket ? Date.now() : null;
      });
    }

    this._sendConfiguration(newConfig);
  }

  _changeQuantity(bucketID, itemIndexInBucket, event) {
    let newConfig = Object.assign({}, this.state.currentConfig);
    newConfig[bucketID][itemIndexInBucket]['quantity'] = parseInt(event.target.value);

    if (newConfig[bucketID][itemIndexInBucket]['selected_at'] != null) {
      this._sendConfiguration(newConfig);
      return;
    }

    this.setState({
      currentConfig: newConfig,
    });
  }

  _priceDiff(bucketID, itemIndexInBucket, isMultiSelect, type = 'price') {
    let priceDiff;
    let currentItem = this.state.currentConfig[bucketID][itemIndexInBucket];
    let selected = currentItem['selected_at'];

    if (isMultiSelect) {
      priceDiff = (selected ? -1 : 1) * currentItem[type] * currentItem['quantity'];
    } else if (selected) {
      priceDiff = 0;
    } else {
      let selectedItem = this.state.currentConfig[bucketID].find(item => item['selected_at']);
      priceDiff = currentItem[type] * currentItem['quantity'] - selectedItem[type] * selectedItem['quantity'];
    }

    if (priceDiff === 0) {
      return this.props.currencyFormatter.format(priceDiff.toFixed(2));
    }

    return (priceDiff > 0 ? '+' : '') + this.props.currencyFormatter.format(priceDiff.toFixed(2));
  }

  _updateFilter(bucketID, filterGroup, event) {
    let selectedFilters = this.state.selectedFilters;
    selectedFilters[bucketID][filterGroup] = event.target.value;

    this.setState({
      selectedFilters: selectedFilters,
    })
  }

  _compareProducts(bucket) {
    let filteredGroups = this._filterBucketGroups(bucket);
    let productIDs = [];
    let selectedProductIDs = [];

    filteredGroups.forEach(group => {
      group['group_items'].forEach(item => {
        productIDs.push(item['original_id']);

        if (item['selected_at']) {
          selectedProductIDs.push(item['original_id']);
        }
      });
    });

    let url = this.props.baseUrl + '/hardware/compare/' + productIDs.join('/') + `?bucket=${bucket['id']}`;

    if (selectedProductIDs) {
      url += `&selectedProducts=${selectedProductIDs.join(',')}`;
    }

    this.setState({
      compareProductHTML: `<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>`,
    }, () => {
      fetch(url, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        }
      })
        .then(response => response.text())
        .then((result) => {
          this.setState({
            compareProductHTML: result,
          });
        });
    });
  }

  _filterBucketGroups(bucket) {
    let filteredGroups = [];

    bucket['groups'].forEach(group => {
      let newGroup = Object.assign({}, group);
      newGroup['group_items'] = group['group_items'].filter(item => {
        for (const [filterGroup, filterValue] of Object.entries(this.state.selectedFilters[bucket['id']])) {
          if (filterValue === 'All') {
            continue;
          }

          let passGroupCheck = false;

          for (const spec of item['specs']) {
            if (spec['name'] === filterGroup && spec['value'] === filterValue) {
              passGroupCheck = true;
              break;
            }
          }

          if (!passGroupCheck) {
            return false;
          }
        }

        return true;
      });

      if (newGroup['group_items'].length > 0) {
        filteredGroups.push(newGroup);
      }
    });

    return filteredGroups;
  }

  _configureSubKit(itemID) {
    let url = this.props.appsUrl + '/api/unified-order/opportunities/prepare';

    fetch(url, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-Token': this.props.csrf,
      },
      body: JSON.stringify(payload)
    }).then(response => response.json())
      .then(result => {
        let systemID = result['opportunity']['opportunity_details'];
        let url = this.props.baseUrl + `/system/${this.state.system['url']}/`;
        window.location.assign(url);
      });
  }

  _getSubKitSummary(item) {
    let summary = item['configuration'].map(item => {
      return item['quantity'] > 1 ? `<b>${item['quantity']} x</b> ${item['name']}` : item['name'];
    }).join('<br>');

    return `<div class="text-start">${summary}</div>`;
  }

  render() {
    let buckets = this.state.system['buckets'].filter(bucket => !bucket['hidden']);
    let currentBucket = buckets[this.state.currentTab];
    let standaloneBucket = buckets.length === 1;
    let prompts = {};

    if (this.state.errors.length > 0) {
      prompts['errors'] = this.state.errors;
    }

    if (this.state.warnings.length > 0) {
      prompts['warnings'] = this.state.warnings;
    }

    if (this.state.additionalItems.length > 0) {
      prompts['additionalItems'] = this.state.additionalItems;
    }

    return (
      <>
        {
          Object.keys(prompts).length > 0 &&
          <div
            className="item-group-vertical position-fixed zindex-fixed bottom-0 end-0 col-xl-3 col-lg-4 col-md-6 px-0 -my-1">
            {
              Object.entries(prompts).map(([promptType, content]) => {
                return content.map(prompt => {
                  let bgColor = promptType === 'errors' ? 'bg-danger' : (promptType === 'warnings' ? 'bg-warning' : 'bg-6');
                  let bucketTab = null;

                  if (Array.isArray(prompt)) {
                    let bucketID = null;
                    [bucketID, prompt] = prompt;

                    bucketTab = this.state.system['buckets'].findIndex(bucket => bucket['id'] === parseInt(bucketID));
                  }

                  return (
                    <div className={`my-1 p-3 ${bgColor} text-white`}>
                      {
                        bucketTab ?
                          <>
                            {`${prompt} `}
                            <a className="text-white text-decoration-underline" href="javascript:void(0)"
                               onClick={() => this._changeTab(bucketTab)}>Go to</a>
                          </>
                          : (
                            promptType === 'additionalItems' ?
                              <>
                                <div className="text-small mb-2">
                                  Additional components have been added to support your selection:
                                </div>
                                {prompt}
                              </>
                              : prompt
                          )
                      }
                    </div>
                  );
                });
              })
            }
          </div>
        }
        <div className="modal fade" id="compare-modal" tabIndex="-1" aria-hidden="true">
          <div className="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl justify-content-center"
               dangerouslySetInnerHTML={{__html: this.state.compareProductHTML}}>

          </div>
        </div>
        <div className="row">
          {
            !standaloneBucket &&
            <div className="col-md-3 col-lg-2">
              <div className="bg-3 shadow-sm d-flex flex-column">
                <div className="p-2 bg-black text-white">
                  <span className="icon-sliders"></span>Configurator
                </div>
                {
                  buckets.map((bucket, index) => {
                    let borderColor = '';

                    if (this.state.errors.filter(error => Array.isArray(error) && error[0] === bucket['id']).length > 0) {
                      borderColor = 'border-danger';
                    } else if (this.state.warnings.filter(warning => Array.isArray(warning) && error[0] === bucket['id']).length > 0) {
                      borderColor = 'border-warning';
                    } else if (this.state.currentTab === index) {
                      borderColor = 'border-primary';
                    }

                    return (
                      <a
                        key={bucket['id']}
                        className={`p-2 border-3 border-end bg-on-hover-4 text-decoration-none ${borderColor} ` + (this.state.currentTab === index ? 'bg-4 text-black' : 'text-muted')}
                        href="javascript:void(0)"
                        onClick={() => this._changeTab(index)}>
                        {bucket['category']}
                      </a>
                    );
                  })
                }
              </div>
            </div>
          }
          <div className={standaloneBucket ? 'col-12' : 'col-md-9 col-lg-10'}>
            {
              buckets.map((bucket, bucketIndex) => {
                let itemsInBucket = this.state.currentConfig[bucket['id']];
                let selectedItemsInBucket = itemsInBucket.filter(item => item['selected_at']);
                let bucketQuantity = selectedItemsInBucket.reduce((a, b) => a + b['quantity'], 0);
                let reachedMaxQuantity = bucket['maxqty'] == null ? false : bucketQuantity >= bucket['maxqty'];
                let isMultiSelect = bucket['multiple'];
                let filteredGroups = this._filterBucketGroups(bucket);
                let filters = [];

                Object.entries(bucket['filters']).forEach(([filterGroup, options]) => {
                  let filteredOptions = options.filter(option => {
                    if (option === 'All') {
                      return true;
                    }

                    for (const group of filteredGroups) {
                      for (const item of group['group_items']) {
                        for (const spec of item['specs']) {
                          if (spec['name'] === filterGroup && spec['value'] === option) {
                            return true;
                          }
                        }
                      }
                    }

                    return false;
                  });

                  // ignore filter groups that are just ['All']
                  if (filteredOptions.length > 1) {
                    filters.push([filterGroup, filteredOptions]);
                  }
                });

                // add counts to filter options
                filters = filters.map(([filterGroup, options]) => {
                  options = options.map(option => {
                    let count = 0;

                    for (const group of filteredGroups) {
                      for (const item of group['group_items']) {
                        for (const spec of item['specs']) {
                          if (spec['name'] === filterGroup && spec['value'] === option) {
                            count += 1;
                            break;
                          }
                        }
                      }
                    }

                    return [option, count];
                  });

                  return [filterGroup, options];
                });

                return (
                  <div key={bucket['id']}
                       className={'item-group-vertical fade ' + (this.state.currentTab === bucketIndex ? 'show' : 'd-none')}>
                    {
                      !standaloneBucket &&
                      <div className="item-group flex-nowrap">
                        <div className="d-flex justify-content-center align-items-center p-3 bg-white border"
                             style={{width: 100, height: 100}}>
                          <img style={{maxWidth: 75, maxHeight: 75}} src={this._getBucketImage(bucket['id'])}/>
                        </div>
                        <div className="bg-3 p-3 d-flex flex-column justify-content-center flex-fill">
                          <div className="d-flex flex-wrap align-items-center">
                            <h6 className="mb-0 pe-2 me-2 border-end border-1 border-dark">{bucket['name']}</h6>
                            {
                              currentBucket['compare'] ?
                                <a className="text-primary text-on-hover-primary-highlight"
                                   href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#compare-modal"
                                   onClick={() => this._compareProducts(currentBucket)}>Compare</a> :
                                <a className="text-muted">
                                  Compare
                                </a>
                            }
                            {
                              !standaloneBucket &&
                              <div className="ms-auto fw-bold text-muted">
                                <span>MIN QUANTITY: {currentBucket['multiple'] ? (currentBucket['minqty'] ?? 0) : 1}</span>
                                <span className="ms-3">
                                  MAX QUANTITY: {currentBucket['multiple'] ? (currentBucket['maxqty'] ??
                                  <i className="icon-infinity"></i>) : currentBucket['quantity'].slice(-1)[0]}
                                </span>
                              </div>
                            }
                          </div>
                          {
                            bucket['notes'] !== '' &&
                            <div dangerouslySetInnerHTML={{__html: bucket['notes']}} className="mt-3"></div>
                          }
                        </div>
                      </div>
                    }
                    {
                      !standaloneBucket && filters.length > 0 &&
                      <div
                        className="d-flex flex-wrap flex-lg-nowrap align-items-center justify-content-between flex-fill bg-3 p-3">
                        <div className="row -mx-2 flex-fill">
                          {
                            filters.slice(0, 4).map(([filterGroup, options]) => (
                              <div className="col-6 col-lg-3 px-2">
                                <div className="fw-bold mb-2 text-nowrap">{filterGroup}:</div>
                                <select className="form-control form-control-sm"
                                        value={this.state.selectedFilters[bucket['id']][filterGroup]}
                                        onChange={(event) => this._updateFilter(bucket['id'], filterGroup, event)}>
                                  {
                                    options.map(([option, count]) => (
                                      <option key={option} value={option}>
                                        {option + (count > 0 ? ` (${count})` : '')}
                                      </option>
                                    ))
                                  }
                                </select>
                              </div>
                            ))
                          }
                        </div>
                        <a
                          className="text-primary text-decoration-none text-nowrap ms-3 text-on-hover-primary-highlight"
                          href="javascript:void(0)" onClick={() => this._clearFilters(bucket['id'])}>
                          Clear Filters
                        </a>
                      </div>
                    }
                    {
                      filteredGroups.map((group, groupIndex) => (
                        <ConditionalWrapper condition={standaloneBucket}
                                            wrapper={children => <div className="row -mx-2">{children}</div>}>
                          {
                            standaloneBucket &&
                            <div className="col-md-3 col-lg-2 px-2">
                              <div
                                className="d-flex justify-content-center align-items-center p-3 bg-white border h-100">
                                <img className="mw-100 mh-100"
                                     src={this._getBucketGroupImage(bucket['id'], groupIndex)}/>
                              </div>
                            </div>
                          }
                          <ConditionalWrapper condition={standaloneBucket}
                                              wrapper={children => <div
                                                className="col-md-9 col-lg-10 px-2">{children}</div>}>
                            <div
                              className={'bg-white p-4 shadow-sm'}>
                              {
                                group['name'] &&
                                <>
                                  <div className="fw-bold">{group['name']}</div>
                                  <hr className="-mx-4"/>
                                </>
                              }
                              {
                                group['group_items'].map((item) => {
                                  let itemIndexInBucket = itemsInBucket.indexOf(item);
                                  let itemInConfiguration = itemsInBucket[itemIndexInBucket];
                                  let checked = itemInConfiguration['selected_at'] != null;
                                  let itemQuantity = itemInConfiguration['quantity'];
                                  let isSystemItem = item['type'] === 'system';
                                  let options = bucket['quantity'].filter(quantityOption => {
                                    if (bucket['maxqty'] == null) {
                                      return true;
                                    }

                                    let selectableQuantity = bucket['maxqty'] - bucketQuantity;

                                    if (checked) {
                                      return quantityOption - itemQuantity <= selectableQuantity;
                                    }

                                    return quantityOption <= selectableQuantity;
                                  });

                                  if (options.length === 0) {
                                    options = [0];
                                  }

                                  if (itemQuantity === 0 || itemQuantity > options[options.length - 1]) {
                                    itemQuantity = options[0];
                                    itemInConfiguration['quantity'] = options[0];
                                  }

                                  let costDifference = 'cost' in item ? this._priceDiff(bucket['id'], itemIndexInBucket, isMultiSelect, 'cost') : null;
                                  let priceDifference = this._priceDiff(bucket['id'], itemIndexInBucket, isMultiSelect, 'price');

                                  return (
                                    <>
                                      <div className="item-group align-items-center my-1">
                                        {
                                          (bucket['quantity'].length > 1 || bucket['quantity'][0] > 1) &&
                                          <>
                                            {
                                              bucket['quantity'].length > 1 ?
                                                <select className="form-control form-control-sm w-auto"
                                                        disabled={!checked && reachedMaxQuantity}
                                                        value={itemQuantity}
                                                        onChange={(event) => this._changeQuantity(bucket['id'], itemIndexInBucket, event)}>
                                                  {
                                                    options.map(quantity => (
                                                      <option key={quantity} value={quantity}>{quantity}</option>))
                                                  }
                                                </select> :
                                                <span>{bucket['quantity'][0]}</span>
                                            }
                                            <span className="icon-cancel text-muted"/>
                                          </>
                                        }
                                        <label className={'d-flex align-items-center' + (checked ? ' fw-bold' : '')}>
                                          <input
                                            className="me-1"
                                            type={isMultiSelect ? 'checkbox' : 'radio'}
                                            value={itemQuantity}
                                            checked={checked}
                                            disabled={isMultiSelect && !checked && reachedMaxQuantity}
                                            onChange={() => this._selectItem(bucket['id'], itemIndexInBucket)}/>
                                          {item['name']}
                                        </label>
                                        {
                                          'availableQuantity' in item &&
                                          <span className={item['availableQuantity'] <= 0 ? 'text-danger' : ''}>
                                          [qty: {item['availableQuantity']}]
                                        </span>
                                        }
                                        {
                                          costDifference === null ?
                                            <span>[ {priceDifference} ]</span> :
                                            <span>[ {costDifference} | {priceDifference} ]</span>
                                        }
                                        {
                                          (item['warning'] || item['status_text']) &&
                                          <span className="bg-warning px-1"
                                                title={item['status_text']}>{item['status']}</span>
                                        }
                                      </div>
                                      {
                                        isSystemItem && checked &&
                                        <div className="item-group align-items-center mt-1" style={{marginLeft: '4.9rem'}}>
                                          <div>
                                            <b>Base Configuration:</b>
                                            <span className="text-primary">
                                                &nbsp;{this.props.currencyFormatter.format(item['price'])}
                                              </span> each
                                          </div>
                                          <a href="javascript:void(0)" className="text-dark" data-bs-toggle="tooltip"
                                             data-bs-html="true" data-bs-placement="bottom" data-bs-trigger="hover"
                                             title={this._getSubKitSummary(item)}>
                                            Detail <i className="icon-info-circled"></i>
                                          </a>
                                          {
                                            this.state.errors.length === 0 &&
                                            <a className="btn btn-sm btn-primary"
                                               onClick={() => this._configureSubKit(item['id'])}>Configure Sub-kit</a>
                                          }
                                        </div>
                                      }
                                    </>
                                  );
                                })
                              }
                            </div>
                          </ConditionalWrapper>
                        </ConditionalWrapper>
                      ))
                    }
                  </div>
                )
              })
            }
          </div>
        </div>
      </>
    );
  }
}
