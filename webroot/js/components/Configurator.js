/**
 * Use <div id="configurator" data-name='name-of-the-field' data-system='...' data-tabs='...'...>
 */
class Configurator extends React.Component {
  constructor(props) {
    super(props);

    let system = JSON.parse(props.system);
    let baseConfig = {};

    system['buckets'].forEach(bucket => {
      let bucketItems = [];

      bucket['groups'].forEach(group => {
        group['group_items'].forEach(item => {
          item['selected_at'] = item['selected'] ? Date.now() : null;
          item['quantity'] = parseInt(item['quantity'] ?? bucket['quantity'][0]);

          bucketItems.push(item);
        });
      });

      baseConfig[bucket['id']] = bucketItems;
    });

    this.updateSystem = this.updateSystem.bind(this);
    this.validateConfiguration = this.validateConfiguration.bind(this);
    this.prepareConfiguration = this.prepareConfiguration.bind(this);
    this.updateConfiguration = this.updateConfiguration.bind(this);
    this.saveConfiguration = this.saveConfiguration.bind(this);
    this.updateComments = this.updateComments.bind(this);
    this.updateQuantity = this.updateQuantity.bind(this);
    this.percentageFormatter = new Intl.NumberFormat(undefined, {
      style: 'percent',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
    this.currencyFormatter = new Intl.NumberFormat(undefined, {
      style: 'currency',
      currency: this.props.currency,
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    this.state = {
      system: system,
      quantity: system['quantity'] ?? 1,
      tabs: JSON.parse(props.tabs),
      currentConfig: baseConfig,
      currentTab: 0,
      validConfiguration: true,
      name: system['config_name'] ?? 'My System ' + (new Date()).toLocaleString(),
      comment: system?.['config_json']?.['comments'] ?? '',
    };
  }

  _changeTab(newTab) {
    this.setState({
      currentTab: newTab,
    });
  }

  _back() {
    if (this.state.currentTab !== 0) {
      this.setState({
        currentTab: Math.max(0, this.state.currentTab - 1),
      });
    }
  }

  _continue() {
    if (this.state.currentTab !== this.state.tabs.length - 1) {
      this.setState({
        currentTab: Math.min(this.state.tabs.length - 1, this.state.currentTab + 1),
      });
    }
  }

  _handleSubmit(event) {
    event.target.form.submit();
  }

  _getFinancingOptions() {
    return `<div class="text-start">
    Financing is available for business purchases greater than $2500.00, and is provided by Direct Capital.<br>
    Full financials are required for amounts greater than $100,000.00.
    </div>
    <div>${this.currencyFormatter.format(this.state.system['price'] / 12)}/mo for 12 months</div>
    <div>${this.currencyFormatter.format(this.state.system['price'] / 24)}/mo for 24 months</div>
    <div>${this.currencyFormatter.format(this.state.system['price'] / 36)}/mo for 36 months</div>
    <div class="text-muted">Requires credit approval, rates subject to changes.</div>`;
  }

  updateComments(event) {
    this.setState({
      comments: event.target.value,
    });
  }

  updateQuantity(event) {
    this.setState({
      quantity: parseInt(event.target.value),
    });
  }

  prepareConfiguration() {
    let selectedBucketObjects = Object.entries(this.state.currentConfig).map(([bucketID, items]) => {
      let selectedItems = items.filter(item => {
        return item['selected_at'] != null;
      }).map(item => {
        return {
          item_id: item['id'],
          qty: item['quantity'],
          ...('config_json' in item ? {subkit: item['config_json']} : {})
        };
      });

      return [bucketID, selectedItems];
    }).filter(([, selectedItems]) => {
      return selectedItems.length > 0;
    });

    return {
      name: this.state.name,
      ...(this.state.comments ? {comments: this.state.comments} : {}),
      config: Object.fromEntries(selectedBucketObjects),
      created_at: this.state.system['config_json']?.['created_at'] ?? parseInt(Date.now().toString().slice(0, -3)),
    };
  }

  validateConfiguration(system, newConfig, callback) {
    let payload = {
      system: system['id'],
      kit: system['kit_id'],
      configuration: this.prepareConfiguration(),
      ...('currentPriceLevel' in this.props ? {priceLevel: this.props['currentPriceLevel']} : {})
    };

    let url = this.props.baseUrl + '/system/configuration/validate';

    this.setState({
      currentConfig: newConfig,
      system: system,
    }, () => {
      fetch(url, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-Token': this.props.csrf,
        },
        body: JSON.stringify(payload)
      })
        .then(response => response.json())
        .then(callback);
    });
  }

  updateConfiguration(callback) {
    let url = this.props.baseUrl + `/system/configuration/update`;

    let payload = {
      config_key: this.props.configKey,
      ...(this.props.subKitPath ? {sub_kit_path: this.props.subKitPath} : {}),
      configuration: this.prepareConfiguration(),
    };

    fetch(url, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-Token': this.props.csrf,
      },
      body: JSON.stringify(payload)
    })
      .then(response => response.json())
      .then(callback);
  }

  saveConfiguration(callback) {
    let url = this.props.baseUrl + `/system/configuration/save`;

    let payload = {
      system: this.state.system['id'],
      opportunity_key: this.props.opportunityKey,
      config_key: this.props.configKey,
      ...(this.props.subKitPath ? {sub_kit_path: this.props.subKitPath} : {}),
      configuration: this.prepareConfiguration(),
    };

    fetch(url, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-Token': this.props.csrf,
      },
      body: JSON.stringify(payload)
    })
      .then(response => response.json())
      .then(callback);
  }

  updateSystem(system, validConfiguration) {
    this.setState({
      system: system,
      validConfiguration: validConfiguration,
    });
  }

  componentDidMount() {
    [...document.querySelectorAll('[data-bs-toggle="tooltip"]')]
      .forEach(el => !el.hasAttribute('data-bs-original-title') && new bootstrap.Tooltip(el));
  }

  componentDidUpdate() {
    [...document.querySelectorAll('[data-bs-toggle="tooltip"]')]
      .forEach(el => !el.hasAttribute('data-bs-original-title') && new bootstrap.Tooltip(el));
  }

  render() {
    let nonStandaloneBuckets = this.state.system['buckets'].filter(bucket => bucket['name'] !== 'Warranty');
    let standaloneBuckets = this.state.system['buckets'].filter(bucket => bucket['name'] === 'Warranty');

    let tabs = Object.assign([], this.state.tabs);
    for (const tab of tabs) {
      switch (tab['name']) {
        case 'Configure':
          tab['content'] = <Configure ref={(configure) => {
            window.configure = configure
          }}
                                      system={this.state.system} buckets={nonStandaloneBuckets}
                                      currentConfig={this.state.currentConfig}
                                      csrf={this.props.csrf} validateConfiguration={this.validateConfiguration}
                                      updateSystem={this.updateSystem} baseUrl={this.props.baseUrl}
                                      currencyFormatter={this.currencyFormatter}
                                      updateConfiguration={this.updateConfiguration}
                                      configKey={this.props.configKey} subKitPath={this.props.subKitPath}
                                      systemUrl={this.props.systemUrl} opportunityKey={this.props.opportunityKey}/>;
          break;
        case 'Storage Setup':
          tab['content'] = <StorageSetup system={this.state.system} currentConfig={this.state.currentConfig}/>;
          break;
        case 'Warranty':
          tab['content'] = <Configure system={this.state.system} buckets={standaloneBuckets}
                                      currentConfig={this.state.currentConfig}
                                      csrf={this.props.csrf} validateConfiguration={this.validateConfiguration}
                                      updateSystem={this.updateSystem} baseUrl={this.props.baseUrl}
                                      currencyFormatter={this.currencyFormatter}
                                      updateConfiguration={this.updateConfiguration}/>;
          break;
        case 'Summary':
          tab['content'] = <Summary system={this.state.system} name={this.state.name} baseUrl={this.props.baseUrl}
                                    currentConfig={this.state.currentConfig}
                                    validConfiguration={this.state.validConfiguration}
                                    validateConfiguration={this.validateConfiguration}
                                    updateConfiguration={this.updateConfiguration}
                                    saveConfiguration={this.saveConfiguration}
                                    updateComments={this.updateComments} updateQuality={this.updateQuantity}
                                    currencyFormatter={this.currencyFormatter} quantity={this.state.quantity}
                                    configKey={this.props.configKey} subKitPath={this.props.subKitPath}
                                    comments={this.state.comments} systemUrl={this.props.systemUrl}
                                    opportunityKey={this.props.opportunityKey}/>;
          break;
      }
    }
    let backUrl =  `${this.props.baseUrl}/sales/quotes/systems/${this.props.opportunityKey}`;

    return (
      <>
        {
          ('currentWarehouse' in this.props || 'currentPriceLevel' in this.props) &&
          <form className="mb-3" method="get">
            <div className="item-group align-items-center">
              <a className="btn btn-secondary py-2" href="javascript:void(0)" onClick={() => lightbox(backUrl)}>
                Back
              </a>
              {
                'currentWarehouse' in this.props &&
                <div className="ms-auto col-lg-3">
                  <label className="fw-bold">Warehouse:</label>
                  <select className="form-control form-control-sm" name="warehouse"
                          defaultValue={this.props.currentWarehouse}
                          onChange={(event) => this._handleSubmit(event)}>
                    {
                      Object.entries(JSON.parse(this.props.warehouses)).map(([id, warehouse]) => (
                        <option key={id} value={id}>{warehouse}</option>
                      ))
                    }
                  </select>
                </div>
              }
              {
                'currentPriceLevel' in this.props &&
                <div className="col-lg-3">
                  <label className="fw-bold">Price Level:</label>
                  <select className="form-control form-control-sm" name="priceLevel"
                          defaultValue={this.props.currentPriceLevel}
                          onChange={(event) => this._handleSubmit(event)}>
                    {
                      Object.entries(JSON.parse(this.props.priceLevels)).map(([id, priceLevel]) => (
                        <option key={id} value={id}>{priceLevel}</option>
                      ))
                    }
                  </select>
                </div>
              }
            </div>
          </form>
        }
        <div className="bg-white">
          <div className="container py-5">
            <div className="row gx-5">
              <div className="col-md-4">
                <div className="d-flex justify-content-center align-items-center" style={{height: 150}}>
                  <img className="mw-100 mh-100" src={this.state.system['image']}/>
                </div>
              </div>
              <div className="col-md-4 d-flex flex-column justify-content-center">
                <h2 className="text-black mb-3">{this.state.system['name']}</h2>
                <div className="item-group mb-3">
                  {
                    this.state.system['power_estimate'] &&
                    <div className="d-flex align-items-center">
                      <span className="h4 mb-0 icon-flash"></span>
                      <div>
                        <div>Estimated Power</div>
                        <div>{this.state.system['power_estimate']}</div>
                      </div>
                    </div>
                  }
                  {
                    this.state.system['nose_level'] &&
                    <div className="d-flex align-items-center">
                      <span className="h4 mb-0 icon-flash"></span>
                      <div>
                        <div>Noise Level</div>
                        <div>{this.state.system['nose_level']}</div>
                      </div>
                    </div>
                  }
                </div>
                <div>
                  Configure your system by selecting the desired item or items from each required
                  parts category below.
                </div>
              </div>
              <div className="col-md-4 d-flex flex-column justify-content-center align-items-start">
                {
                  this.state.validConfiguration ?
                    (
                      <>
                        {
                          'cost' in this.state.system ?
                            [['CONFIGURED PRICE', this.currencyFormatter.format(this.state.system['price'])],
                              ['COST', this.currencyFormatter.format(this.state.system['cost'])],
                              ['GROSS MARGIN', this.percentageFormatter.format(this.state.system['margin'])]
                            ].map(([title, value]) =>
                              <div className="mb-1">
                                <h6 className="text-muted mb-0">
                                  {title}:
                                </h6>
                                <h4 className="text-primary">
                                  {value}
                                </h4>
                              </div>
                            ) :
                            <>
                              <h5 className="text-muted">
                                CONFIGURED PRICE:
                              </h5>
                              <h2 className="text-primary">
                                {this.currencyFormatter.format(this.state.system['price'])}
                              </h2>
                            </>
                        }
                        {
                          this.state.system['price'] > 2500 &&
                          <a href="javascript:void(0)" className="text-muted" data-bs-toggle="tooltip"
                             data-bs-html="true" data-bs-placement="bottom" data-bs-trigger="hover"
                             title={this._getFinancingOptions()}>
                            From {this.currencyFormatter.format(this.state.system['price'] / 36)}/mo <i
                            className="icon-info-circled"/>
                          </a>
                        }
                      </>
                    ) :
                    <h4 className="text-primary">
                      Invalid Configuration
                    </h4>
                }
              </div>
            </div>
          </div>
        </div>
        <div className="container py-5">
          <div className="border-bottom sticky-top bg-2">
            <div className="item-group -mx-4">
              {tabs.map((tab, index) => (
                <a
                  className={'text-decoration-none fw-bold py-2 mx-4 ' + (this.state.currentTab === index ? 'text-black border-2 border-bottom border-primary' : 'text-muted')}
                  href="javascript:void(0)" onClick={() => this._changeTab(index)}>
                  Step {`${index + 1}: ${tab['name']}`}
                </a>
              ))}
            </div>
          </div>
          <div className="py-5">
            {tabs.map((tab, index) => (
              <div className={'fade ' + (this.state.currentTab === index ? 'show' : 'd-none')}>
                <div className="h2 fw-bold">
                  Step {`${index + 1}: ${tab['name']}`}
                </div>
                <p className="mb-5">{tab['description']}</p>
                {tab['content']}
              </div>
            ))}
          </div>
          <div className="d-flex justify-content-between">
            <a className="text-primary text-on-hover-primary-highlight text-decoration-none" href="javascript:void(0)"
               onClick={() => this._back()}>
              <span className="bg-primary text-white p-1 icon-left-open me-2"></span>
              Go Back
            </a>
            <a className="text-primary text-on-hover-primary-highlight text-decoration-none" href="javascript:void(0)"
               onClick={() => this._continue()}>
              Continue
              <span className="bg-primary text-white p-1 icon-right-open ms-2"></span>
            </a>
          </div>
        </div>
      </>
    );
  }
}

const configurator = document.getElementById('configurator');
ReactDOM.render(<Configurator {...(configurator.dataset)}/>, configurator);
