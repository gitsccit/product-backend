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
      maximumFractionDigits: 2
    });
    this.currencyFormatter = new Intl.NumberFormat(undefined, {
      style: 'currency',
      currency: this.props.currency,
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
    this.state = {
      system: system,
      quantity: system['quantity'] ?? 1,
      tabs: JSON.parse(props.tabs),
      currentConfig: baseConfig,
      currentTab: 0,
      validConfiguration: true,
      name: system['config_name'] ?? 'My System ' + new Date().toLocaleString(),
      comment: system?.['config_json']?.['comments'] ?? ''
    };
  }

  _changeTab(newTab) {
    this.setState({
      currentTab: newTab
    });
  }

  _back() {
    if (this.state.currentTab !== 0) {
      this.setState({
        currentTab: Math.max(0, this.state.currentTab - 1)
      });
    }
  }

  _continue() {
    if (this.state.currentTab !== this.state.tabs.length - 1) {
      this.setState({
        currentTab: Math.min(this.state.tabs.length - 1, this.state.currentTab + 1)
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
      comments: event.target.value
    });
  }

  updateQuantity(event) {
    this.setState({
      quantity: parseInt(event.target.value)
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
          ...('config_json' in item ? {
            subkit: item['config_json']
          } : {})
        };
      });
      return [bucketID, selectedItems];
    }).filter(([, selectedItems]) => {
      return selectedItems.length > 0;
    });
    return {
      name: this.state.name,
      ...(this.state.comments ? {
        comments: this.state.comments
      } : {}),
      config: Object.fromEntries(selectedBucketObjects),
      created_at: this.state.system['config_json']?.['created_at'] ?? parseInt(Date.now().toString().slice(0, -3))
    };
  }

  validateConfiguration(system, newConfig, callback) {
    let payload = {
      system: system['id'],
      kit: system['kit_id'],
      configuration: this.prepareConfiguration(),
      ...('currentPriceLevel' in this.props ? {
        priceLevel: this.props['currentPriceLevel']
      } : {})
    };
    let url = this.props.baseUrl + '/system/configuration/validate';
    this.setState({
      currentConfig: newConfig,
      system: system
    }, () => {
      fetch(url, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-Token': this.props.csrf
        },
        body: JSON.stringify(payload)
      }).then(response => response.json()).then(callback);
    });
  }

  updateConfiguration(callback) {
    let url = this.props.baseUrl + `/system/configuration/update`;
    let payload = {
      config_key: this.props.configKey,
      ...(this.props.subKitPath ? {
        sub_kit_path: this.props.subKitPath
      } : {}),
      configuration: this.prepareConfiguration()
    };
    fetch(url, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-Token': this.props.csrf
      },
      body: JSON.stringify(payload)
    }).then(response => response.json()).then(callback);
  }

  saveConfiguration(callback) {
    let url = this.props.baseUrl + `/system/configuration/save`;
    let payload = {
      system: this.state.system['id'],
      opportunity_key: this.props.opportunityKey,
      config_key: this.props.configKey,
      qty: this.state.quantity,
      ...(this.props.subKitPath ? {
        sub_kit_path: this.props.subKitPath
      } : {}),
      configuration: this.prepareConfiguration()
    };
    fetch(url, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-Token': this.props.csrf
      },
      body: JSON.stringify(payload)
    }).then(response => response.json()).then(callback);
  }

  updateSystem(system, validConfiguration) {
    this.setState({
      system: system,
      validConfiguration: validConfiguration
    });
  }

  componentDidMount() {
    [...document.querySelectorAll('[data-bs-toggle="tooltip"]')].forEach(el => !el.hasAttribute('data-bs-original-title') && new bootstrap.Tooltip(el));
  }

  componentDidUpdate() {
    [...document.querySelectorAll('[data-bs-toggle="tooltip"]')].forEach(el => !el.hasAttribute('data-bs-original-title') && new bootstrap.Tooltip(el));
  }

  render() {
    let nonStandaloneBuckets = this.state.system['buckets'].filter(bucket => bucket['name'] !== 'Warranty');
    let standaloneBuckets = this.state.system['buckets'].filter(bucket => bucket['name'] === 'Warranty');
    let tabs = Object.assign([], this.state.tabs);

    for (const tab of tabs) {
      switch (tab['name']) {
        case 'Configure':
          tab['content'] = /*#__PURE__*/React.createElement(Configure, {
            ref: configure => {
              window.configure = configure;
            },
            system: this.state.system,
            buckets: nonStandaloneBuckets,
            currentConfig: this.state.currentConfig,
            csrf: this.props.csrf,
            validateConfiguration: this.validateConfiguration,
            updateSystem: this.updateSystem,
            baseUrl: this.props.baseUrl,
            currencyFormatter: this.currencyFormatter,
            updateConfiguration: this.updateConfiguration,
            configKey: this.props.configKey,
            subKitPath: this.props.subKitPath,
            systemUrl: this.props.systemUrl,
            opportunityKey: this.props.opportunityKey
          });
          break;

        case 'Storage Setup':
          tab['content'] = /*#__PURE__*/React.createElement(StorageSetup, {
            system: this.state.system,
            currentConfig: this.state.currentConfig
          });
          break;

        case 'Warranty':
          tab['content'] = /*#__PURE__*/React.createElement(Configure, {
            system: this.state.system,
            buckets: standaloneBuckets,
            currentConfig: this.state.currentConfig,
            csrf: this.props.csrf,
            validateConfiguration: this.validateConfiguration,
            updateSystem: this.updateSystem,
            baseUrl: this.props.baseUrl,
            currencyFormatter: this.currencyFormatter,
            updateConfiguration: this.updateConfiguration
          });
          break;

        case 'Summary':
          tab['content'] = /*#__PURE__*/React.createElement(Summary, {
            system: this.state.system,
            name: this.state.name,
            baseUrl: this.props.baseUrl,
            currentConfig: this.state.currentConfig,
            validConfiguration: this.state.validConfiguration,
            validateConfiguration: this.validateConfiguration,
            updateConfiguration: this.updateConfiguration,
            saveConfiguration: this.saveConfiguration,
            updateComments: this.updateComments,
            updateQuality: this.updateQuantity,
            currencyFormatter: this.currencyFormatter,
            quantity: this.state.quantity,
            configKey: this.props.configKey,
            subKitPath: this.props.subKitPath,
            comments: this.state.comments,
            systemUrl: this.props.systemUrl,
            opportunityKey: this.props.opportunityKey
          });
          break;
      }
    }

    let backUrl = `${this.props.baseUrl}/sales/quotes/systems/${this.props.opportunityKey}`;
    return /*#__PURE__*/React.createElement(React.Fragment, null, ('currentWarehouse' in this.props || 'currentPriceLevel' in this.props) && /*#__PURE__*/React.createElement("form", {
      className: "mb-3",
      method: "get"
    }, /*#__PURE__*/React.createElement("div", {
      className: "item-group align-items-center"
    }, /*#__PURE__*/React.createElement("a", {
      className: "btn btn-secondary py-2",
      href: "javascript:void(0)",
      onClick: () => lightbox(backUrl)
    }, "Back"), 'currentWarehouse' in this.props && /*#__PURE__*/React.createElement("div", {
      className: "ms-auto col-lg-3"
    }, /*#__PURE__*/React.createElement("label", {
      className: "fw-bold"
    }, "Warehouse:"), /*#__PURE__*/React.createElement("select", {
      className: "form-control form-control-sm",
      name: "warehouse",
      defaultValue: this.props.currentWarehouse,
      onChange: event => this._handleSubmit(event)
    }, Object.entries(JSON.parse(this.props.warehouses)).map(([id, warehouse]) => /*#__PURE__*/React.createElement("option", {
      key: id,
      value: id
    }, warehouse)))), 'currentPriceLevel' in this.props && /*#__PURE__*/React.createElement("div", {
      className: "col-lg-3"
    }, /*#__PURE__*/React.createElement("label", {
      className: "fw-bold"
    }, "Price Level:"), /*#__PURE__*/React.createElement("select", {
      className: "form-control form-control-sm",
      name: "priceLevel",
      defaultValue: this.props.currentPriceLevel,
      onChange: event => this._handleSubmit(event)
    }, Object.entries(JSON.parse(this.props.priceLevels)).map(([id, priceLevel]) => /*#__PURE__*/React.createElement("option", {
      key: id,
      value: id
    }, priceLevel)))))), /*#__PURE__*/React.createElement("div", {
      className: "bg-white"
    }, /*#__PURE__*/React.createElement("div", {
      className: "container py-5"
    }, /*#__PURE__*/React.createElement("div", {
      className: "row gx-5"
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-md-4"
    }, /*#__PURE__*/React.createElement("div", {
      className: "d-flex justify-content-center align-items-center",
      style: {
        height: 150
      }
    }, /*#__PURE__*/React.createElement("img", {
      className: "mw-100 mh-100",
      src: this.state.system['image']
    }))), /*#__PURE__*/React.createElement("div", {
      className: "col-md-4 d-flex flex-column justify-content-center"
    }, /*#__PURE__*/React.createElement("h2", {
      className: "text-black mb-3"
    }, this.state.system['name']), /*#__PURE__*/React.createElement("div", {
      className: "item-group mb-3"
    }, this.state.system['power_estimate'] && /*#__PURE__*/React.createElement("div", {
      className: "d-flex align-items-center"
    }, /*#__PURE__*/React.createElement("span", {
      className: "h4 mb-0 icon-flash"
    }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", null, "Estimated Power"), /*#__PURE__*/React.createElement("div", null, this.state.system['power_estimate']))), this.state.system['nose_level'] && /*#__PURE__*/React.createElement("div", {
      className: "d-flex align-items-center"
    }, /*#__PURE__*/React.createElement("span", {
      className: "h4 mb-0 icon-flash"
    }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", null, "Noise Level"), /*#__PURE__*/React.createElement("div", null, this.state.system['nose_level'])))), /*#__PURE__*/React.createElement("div", null, "Configure your system by selecting the desired item or items from each required parts category below.")), /*#__PURE__*/React.createElement("div", {
      className: "col-md-4 d-flex flex-column justify-content-center align-items-start"
    }, this.state.validConfiguration ? /*#__PURE__*/React.createElement(React.Fragment, null, 'cost' in this.state.system ? [['CONFIGURED PRICE', this.currencyFormatter.format(this.state.system['price'])], ['COST', this.currencyFormatter.format(this.state.system['cost'])], ['GROSS MARGIN', this.percentageFormatter.format(this.state.system['margin'])]].map(([title, value]) => /*#__PURE__*/React.createElement("div", {
      className: "mb-1"
    }, /*#__PURE__*/React.createElement("h6", {
      className: "text-muted mb-0"
    }, title, ":"), /*#__PURE__*/React.createElement("h4", {
      className: "text-primary"
    }, value))) : /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("h5", {
      className: "text-muted"
    }, "CONFIGURED PRICE:"), /*#__PURE__*/React.createElement("h2", {
      className: "text-primary"
    }, this.currencyFormatter.format(this.state.system['price']))), this.state.system['price'] > 2500 && /*#__PURE__*/React.createElement("a", {
      href: "javascript:void(0)",
      className: "text-muted",
      "data-bs-toggle": "tooltip",
      "data-bs-html": "true",
      "data-bs-placement": "bottom",
      "data-bs-trigger": "hover",
      title: this._getFinancingOptions()
    }, "From ", this.currencyFormatter.format(this.state.system['price'] / 36), "/mo ", /*#__PURE__*/React.createElement("i", {
      className: "icon-info-circled"
    }))) : /*#__PURE__*/React.createElement("h4", {
      className: "text-primary"
    }, "Invalid Configuration"))))), /*#__PURE__*/React.createElement("div", {
      className: "container py-5"
    }, /*#__PURE__*/React.createElement("div", {
      className: "border-bottom bg-2"
    }, /*#__PURE__*/React.createElement("div", {
      className: "item-group -mx-4"
    }, tabs.map((tab, index) => /*#__PURE__*/React.createElement("a", {
      className: 'text-decoration-none fw-bold py-2 mx-4 ' + (this.state.currentTab === index ? 'text-black border-2 border-bottom border-primary' : 'text-muted'),
      href: "javascript:void(0)",
      onClick: () => this._changeTab(index)
    }, "Step ", `${index + 1}: ${tab['name']}`)))), /*#__PURE__*/React.createElement("div", {
      className: "py-5"
    }, tabs.map((tab, index) => /*#__PURE__*/React.createElement("div", {
      className: 'fade ' + (this.state.currentTab === index ? 'show' : 'd-none')
    }, /*#__PURE__*/React.createElement("div", {
      className: "h2 fw-bold"
    }, "Step ", `${index + 1}: ${tab['name']}`), /*#__PURE__*/React.createElement("p", {
      className: "mb-5"
    }, tab['description']), tab['content']))), /*#__PURE__*/React.createElement("div", {
      className: "d-flex justify-content-between"
    }, /*#__PURE__*/React.createElement("a", {
      className: "text-primary text-on-hover-primary-highlight text-decoration-none",
      href: "javascript:void(0)",
      onClick: () => this._back()
    }, /*#__PURE__*/React.createElement("span", {
      className: "bg-primary text-white p-1 icon-left-open me-2"
    }), "Go Back"), /*#__PURE__*/React.createElement("a", {
      className: "text-primary text-on-hover-primary-highlight text-decoration-none",
      href: "javascript:void(0)",
      onClick: () => this._continue()
    }, "Continue", /*#__PURE__*/React.createElement("span", {
      className: "bg-primary text-white p-1 icon-right-open ms-2"
    })))));
  }

}

const configurator = document.getElementById('configurator');
ReactDOM.render( /*#__PURE__*/React.createElement(Configurator, configurator.dataset), configurator);