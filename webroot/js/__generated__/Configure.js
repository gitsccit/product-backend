class Configure extends React.Component {
  constructor(props) {
    super(props);
    let selectedFilters = {};
    let buckets = props.buckets.filter(bucket => !bucket['hidden']);
    buckets.forEach(bucket => {
      let bucketFilters = {};
      Object.entries(bucket['filters']).forEach(([name, options]) => {
        bucketFilters[name] = Object.values(options)[0];
      });
      selectedFilters[bucket['id']] = bucketFilters;
    });
    this.state = {
      system: props.system,
      buckets: buckets,
      currentConfig: props.currentConfig,
      selectedFilters: selectedFilters,
      errors: [],
      warnings: [],
      additionalItems: []
    };
    this.bucketTopOffset = 35;
  }

  _getBucketImage(bucketID) {
    let itemsInBucket = this.state.currentConfig[bucketID];
    let lastSelectedItem = itemsInBucket.filter(item => item['selected_at']).sort((a, b) => a['selected_at'] - b['selected_at']).pop();

    if (lastSelectedItem) {
      return lastSelectedItem['image'];
    }

    let firstItemInBucket = itemsInBucket[0];
    return firstItemInBucket['image'];
  }

  _getBucketGroupImage(bucketID, groupIndex) {
    let groupItems = this.state.buckets.filter(bucket => bucket['id'] === bucketID)[0]['groups'][groupIndex]['group_items'];
    let lastSelectedItemInGroup = groupItems.filter(item => item['selected_at']).sort((a, b) => a['selected_at'] - b['selected_at']).pop();

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
      selectedFilters: filters
    });
  }

  _sendConfiguration(newConfig) {
    let system = Object.assign({}, this.state.system);
    this.props.validateConfiguration(this.state.system, newConfig, result => {
      system['price'] = result['price'];

      if ('cost' in result) {
        system['cost'] = result['cost'];
        system['margin'] = (result['price'] - result['cost']) / result['price'];
      }

      let validConfiguration = result['errors'].length === 0;
      this.setState({
        currentConfig: newConfig,
        system: system,
        warnings: result['warnings'],
        errors: result['errors'],
        additionalItems: result['additionalItems']
      }, () => {
        this.props.updateSystem(system, validConfiguration);
      });
    });
  }

  _selectItem(bucketID, itemIndexInBucket) {
    let newConfig = Object.assign({}, this.state.currentConfig);
    let item = newConfig[bucketID][itemIndexInBucket];
    let bucket = this.state.buckets.find(bucket => bucket['id'] === bucketID);

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
      currentConfig: newConfig
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
      selectedFilters: selectedFilters
    });
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

    this.compareModal.fetchContent(url);
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

  _configureSubKit(bucketID, subKitIndexInBucket) {
    let itemsInBucket = this.state.currentConfig[bucketID];
    let selectedItemsInBucketBeforeSubKit = itemsInBucket.slice(0, subKitIndexInBucket + 1).filter(item => item['selected_at']);
    let subKitIndexInBucketConfig = selectedItemsInBucketBeforeSubKit.length - 1;
    let subKitPath = `config.${bucketID}.${subKitIndexInBucketConfig}.subkit`;
    let path = this.props.subKitPath ? `${this.props.subKitPath}.${subKitPath}` : subKitPath;
    this.props.updateConfiguration(_ => {
      let [, query] = window.location.href.split('?');
      let url = `${this.props.baseUrl}/system/${this.props.systemUrl}/${this.props.opportunityKey}/${this.props.configKey}/${btoa(path)}` + (query ? `?${query}` : '');

      if ('cost' in this.state.system) {
        lightbox(url);
        return;
      }

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
    let buckets = this.state.buckets;
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

    return /*#__PURE__*/React.createElement(React.Fragment, null, Object.keys(prompts).length > 0 && /*#__PURE__*/React.createElement("div", {
      className: "item-group-vertical position-fixed zindex-fixed bottom-0 end-0 col-xl-3 col-lg-4 col-md-6 px-0 -my-1"
    }, Object.entries(prompts).map(([promptType, content]) => {
      return content.map(prompt => {
        let bgColor = promptType === 'errors' ? 'bg-danger' : promptType === 'warnings' ? 'bg-warning' : 'bg-6';
        let bucketTab = null;

        if (Array.isArray(prompt)) {
          let bucketID = null;
          [bucketID, prompt] = prompt;
          bucketTab = this.state.buckets.findIndex(bucket => bucket['id'] === parseInt(bucketID));
        }

        return /*#__PURE__*/React.createElement("div", {
          className: `my-1 p-3 ${bgColor} text-white`
        }, bucketTab ? /*#__PURE__*/React.createElement(React.Fragment, null, `${prompt} `, /*#__PURE__*/React.createElement("a", {
          className: "text-white text-decoration-underline",
          href: `#list-item-${bucket['id']}`
        }, "Go to")) : promptType === 'additionalItems' ? /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
          className: "text-small mb-2"
        }, "Additional components have been added to support your selection:"), prompt) : prompt);
      });
    })), /*#__PURE__*/React.createElement(Modal, {
      ref: modal => {
        this.compareModal = modal;
      },
      id: "compare-modal",
      url: this.state.compareUrl,
      size: "xl"
    }), /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, !standaloneBucket && /*#__PURE__*/React.createElement("div", {
      className: "col-md-3 col-lg-2"
    }, /*#__PURE__*/React.createElement("div", {
      id: "bucket-list",
      className: "bg-3 shadow-sm d-flex flex-column list-group sticky-top",
      style: {
        top: this.bucketTopOffset
      }
    }, /*#__PURE__*/React.createElement("div", {
      className: "p-2 bg-black text-white"
    }, /*#__PURE__*/React.createElement("span", {
      className: "icon-sliders"
    }), "Configurator"), buckets.map((bucket, index) => {
      let borderColor = '';

      if (this.state.errors.filter(error => Array.isArray(error) && error[0] === bucket['id']).length > 0) {
        borderColor = 'border-danger';
      } else if (this.state.warnings.filter(warning => Array.isArray(warning) && error[0] === bucket['id']).length > 0) {
        borderColor = 'border-warning';
      }

      return /*#__PURE__*/React.createElement("a", {
        key: bucket['id'],
        className: `p-2 border-3 border-end bg-on-hover-4 text-decoration-none list-group-item list-group-item-action ${borderColor}`,
        href: `#list-item-${bucket['id']}`
      }, bucket['category']);
    }))), /*#__PURE__*/React.createElement("div", {
      className: standaloneBucket ? 'col-12' : 'col-md-9 col-lg-10'
    }, /*#__PURE__*/React.createElement("div", {
      id: "buckets",
      className: "position-relative",
      "data-bs-spy": "scroll",
      "data-bs-target": "#bucket-list",
      tabIndex: "0"
    }, buckets.map((bucket, bucketIndex) => {
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
        }); // ignore filter groups that are just ['All']

        if (filteredOptions.length > 1) {
          filters.push([filterGroup, filteredOptions]);
        }
      }); // add counts to filter options

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
      return /*#__PURE__*/React.createElement("div", {
        key: bucket['id'],
        id: `list-item-${bucket['id']}`,
        className: "item-group-vertical" + (bucketIndex == buckets.length - 1 ? '' : ' mb-5')
      }, /*#__PURE__*/React.createElement("h3", null, bucket['name']), !standaloneBucket && /*#__PURE__*/React.createElement("div", {
        className: "item-group flex-nowrap"
      }, /*#__PURE__*/React.createElement("div", {
        className: "d-flex justify-content-center align-items-center p-3 bg-white border",
        style: {
          width: 100,
          height: 100
        }
      }, /*#__PURE__*/React.createElement("img", {
        style: {
          maxWidth: 75,
          maxHeight: 75
        },
        src: this._getBucketImage(bucket['id'])
      })), /*#__PURE__*/React.createElement("div", {
        className: "bg-3 p-3 d-flex flex-column justify-content-center flex-fill"
      }, /*#__PURE__*/React.createElement("div", {
        className: "d-flex flex-wrap align-items-center"
      }, /*#__PURE__*/React.createElement("h6", {
        className: "mb-0 pe-2 me-2 border-end border-1 border-dark"
      }, bucket['name']), bucket['compare'] ? /*#__PURE__*/React.createElement("a", {
        className: "text-primary text-on-hover-primary-highlight",
        href: "javascript:void(0)",
        "data-bs-toggle": "modal",
        "data-bs-target": "#compare-modal",
        onClick: () => this._compareProducts(bucket)
      }, "Compare") : /*#__PURE__*/React.createElement("a", {
        className: "text-muted"
      }, "Compare"), !standaloneBucket && /*#__PURE__*/React.createElement("div", {
        className: "ms-auto fw-bold text-muted"
      }, /*#__PURE__*/React.createElement("span", null, "MIN QUANTITY: ", bucket['multiple'] ? bucket['minqty'] ?? 0 : 1), /*#__PURE__*/React.createElement("span", {
        className: "ms-3"
      }, "MAX QUANTITY: ", bucket['multiple'] ? bucket['maxqty'] ?? /*#__PURE__*/React.createElement("i", {
        className: "icon-infinity"
      }) : bucket['quantity'].slice(-1)[0]))), bucket['notes'] !== '' && /*#__PURE__*/React.createElement("div", {
        dangerouslySetInnerHTML: {
          __html: bucket['notes']
        },
        className: "mt-3"
      }))), !standaloneBucket && filters.length > 0 && /*#__PURE__*/React.createElement("div", {
        className: "d-flex flex-wrap flex-lg-nowrap align-items-center justify-content-between flex-fill bg-3 p-3"
      }, /*#__PURE__*/React.createElement("div", {
        className: "row -mx-2 flex-fill"
      }, filters.slice(0, 4).map(([filterGroup, options]) => {
        let currentGroupSelectedFilter = this.state.selectedFilters[bucket['id']][filterGroup];
        return /*#__PURE__*/React.createElement("div", {
          className: "col-6 col-lg-3 px-2"
        }, /*#__PURE__*/React.createElement("div", {
          className: "fw-bold mb-2 text-nowrap"
        }, filterGroup, ":"), /*#__PURE__*/React.createElement("select", {
          className: 'form-control form-control-sm' + (currentGroupSelectedFilter === 'All' ? '' : ' border-primary text-primary'),
          value: currentGroupSelectedFilter,
          onChange: event => this._updateFilter(bucket['id'], filterGroup, event)
        }, options.map(([option, count]) => /*#__PURE__*/React.createElement("option", {
          className: option === currentGroupSelectedFilter && option !== 'All' ? 'text-primary' : 'text-black',
          key: option,
          value: option
        }, option + (count > 0 ? ` (${count})` : '')))));
      })), /*#__PURE__*/React.createElement("a", {
        className: "text-primary text-decoration-none text-nowrap ms-3 text-on-hover-primary-highlight",
        href: "javascript:void(0)",
        onClick: () => this._clearFilters(bucket['id'])
      }, "Clear Filters")), filteredGroups.map((group, groupIndex) => /*#__PURE__*/React.createElement(ConditionalWrapper, {
        condition: standaloneBucket,
        wrapper: children => /*#__PURE__*/React.createElement("div", {
          className: "row -mx-2"
        }, children)
      }, standaloneBucket && /*#__PURE__*/React.createElement("div", {
        className: "col-md-3 col-lg-2 px-2"
      }, /*#__PURE__*/React.createElement("div", {
        className: "d-flex justify-content-center align-items-center p-3 bg-white border h-100"
      }, /*#__PURE__*/React.createElement("img", {
        className: "mw-100 mh-100",
        src: this._getBucketGroupImage(bucket['id'], groupIndex)
      }))), /*#__PURE__*/React.createElement(ConditionalWrapper, {
        condition: standaloneBucket,
        wrapper: children => /*#__PURE__*/React.createElement("div", {
          className: "col-md-9 col-lg-10 px-2"
        }, children)
      }, /*#__PURE__*/React.createElement("div", {
        className: 'bg-white p-4 shadow-sm'
      }, group['name'] && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
        className: "fw-bold"
      }, group['name']), /*#__PURE__*/React.createElement("hr", {
        className: "-mx-4"
      })), group['group_items'].map(item => {
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

        return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
          className: "item-group align-items-center my-1"
        }, (bucket['quantity'].length > 1 || bucket['quantity'][0] > 1) && /*#__PURE__*/React.createElement(React.Fragment, null, bucket['quantity'].length > 1 ? /*#__PURE__*/React.createElement("select", {
          className: "form-control form-control-sm w-auto",
          disabled: !checked && reachedMaxQuantity,
          value: itemQuantity,
          onChange: event => this._changeQuantity(bucket['id'], itemIndexInBucket, event)
        }, options.map(quantity => /*#__PURE__*/React.createElement("option", {
          key: quantity,
          value: quantity
        }, quantity))) : /*#__PURE__*/React.createElement("span", null, bucket['quantity'][0]), /*#__PURE__*/React.createElement("span", {
          className: "icon-cancel text-muted"
        })), /*#__PURE__*/React.createElement("label", {
          className: 'd-flex align-items-center' + (checked ? ' fw-bold' : '')
        }, /*#__PURE__*/React.createElement("input", {
          className: "me-1",
          type: isMultiSelect ? 'checkbox' : 'radio',
          value: itemQuantity,
          checked: checked,
          disabled: isMultiSelect && !checked && reachedMaxQuantity,
          onChange: () => this._selectItem(bucket['id'], itemIndexInBucket)
        }), item['name']), 'availableQuantity' in item && /*#__PURE__*/React.createElement("span", {
          className: item['availableQuantity'] <= 0 ? 'text-danger' : ''
        }, "[qty: ", item['availableQuantity'], "]"), costDifference === null ? /*#__PURE__*/React.createElement("span", null, "[ ", priceDifference, " ]") : /*#__PURE__*/React.createElement("span", null, "[ ", costDifference, " | ", priceDifference, " ]"), (item['warning'] || item['status_text']) && /*#__PURE__*/React.createElement("span", {
          className: "bg-warning px-1",
          title: item['status_text']
        }, item['status'])), isSystemItem && checked && /*#__PURE__*/React.createElement("div", {
          className: "item-group align-items-center mt-1",
          style: {
            marginLeft: '5rem'
          }
        }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("b", null, item['config_name'] ?? 'Base Configuration'), ":", /*#__PURE__*/React.createElement("span", {
          className: "text-primary"
        }, "\xA0", this.props.currencyFormatter.format(item['price'])), " each"), /*#__PURE__*/React.createElement("a", {
          href: "javascript:void(0)",
          className: "text-dark",
          "data-bs-toggle": "tooltip",
          "data-bs-html": "true",
          "data-bs-placement": "bottom",
          "data-bs-trigger": "hover",
          title: this._getSubKitSummary(item)
        }, "Detail ", /*#__PURE__*/React.createElement("i", {
          className: "icon-info-circled"
        })), this.state.errors.length === 0 && /*#__PURE__*/React.createElement("a", {
          className: "btn btn-sm btn-primary",
          onClick: () => this._configureSubKit(bucket['id'], itemIndexInBucket)
        }, 'config_name' in item ? 'Reconfigure' : 'Configure', " Sub-Kit")));
      }))))));
    })))));
  }

}