/**
 * Use <div id="configurator" data-name='name-of-the-field' data-system='...' data-tabs='...'...>
 */
class Configurator extends React.Component {
  constructor(props) {
    super(props);
    let system = JSON.parse(props.system);
    let opportunity = JSON.parse(props.opportunity);
    let baseConfig = {};
    system['buckets'].forEach(bucket => {
      let bucketItems = [];
      bucket['groups'].forEach(group => {
        group['group_items'].forEach(item => {
          item['selected_at'] = null;
          item['quantity'] = parseInt(bucket['quantity'][0]);

          if (opportunity === null) {
            system['system_items'].forEach(entry => {
              if (item['id'] === entry['item_id']) {
                item['selected_at'] = Date.now();
                item['quantity'] = parseInt(entry['quantity']);
              }
            });
          } else {}

          bucketItems.push(item);
        });
      });
      baseConfig[bucket['id']] = bucketItems;
    });
    this.validateConfiguration = this.validateConfiguration.bind(this);
    this.updateSystem = this.updateSystem.bind(this);
    this.prepareConfiguration = this.prepareConfiguration.bind(this);
    this.currencyFormatter = new Intl.NumberFormat(undefined, {
      style: 'currency',
      currency: this.props.currency,
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
    this.state = {
      system: system,
      tabs: JSON.parse(props.tabs),
      currentConfig: baseConfig,
      currentTab: 0,
      validConfiguration: true,
      name: 'My System ' + new Date().toString()
    };
  }

  _changeTab(newTab) {
    this.setState({
      currentTab: newTab
    });
  }

  _back() {
    this.setState({
      currentTab: Math.max(0, this.state.currentTab - 1)
    });
  }

  _continue() {
    this.setState({
      currentTab: Math.min(this.state.tabs.length, this.state.currentTab + 1)
    });
  }

  _handleSubmit(event) {
    event.target.form.submit();
  }

  prepareConfiguration() {
    let selectedBucketObjects = Object.entries(this.state.currentConfig).map(([bucketID, items]) => {
      let selectedItems = items.filter(item => {
        return item['selected_at'] != null;
      }).map(item => {
        let config = {
          'item_id': item['id'],
          'qty': item['quantity']
        };

        if ('configuration' in item) {
          config['subkit'] = item['subkit'];
        }

        return config;
      });
      return [bucketID, selectedItems];
    }).filter(([, selectedItems]) => {
      return selectedItems.length > 0;
    });
    return Object.fromEntries(selectedBucketObjects);
  }

  validateConfiguration(system, newConfig, callback) {
    let configuration = this.prepareConfiguration();
    let payload = {
      system: system['id'],
      kit: system['kit_id'],
      configuration: configuration
    };

    if ('currentPriceLevel' in this.props) {
      payload['priceLevel'] = this.props['currentPriceLevel'];
    }

    let url = this.props.baseUrl + '/system/validate';
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

  updateSystem(system, validConfiguration) {
    this.setState({
      system: system,
      validConfiguration: validConfiguration
    });
  }

  render() {
    let systemWithoutStandaloneBuckets = Object.assign({}, this.state.system);
    systemWithoutStandaloneBuckets['buckets'] = systemWithoutStandaloneBuckets['buckets'].filter(bucket => bucket['name'] !== 'Warranty');
    let systemWithOnlyStandaloneBuckets = Object.assign({}, this.state.system);
    systemWithOnlyStandaloneBuckets['buckets'] = systemWithOnlyStandaloneBuckets['buckets'].filter(bucket => bucket['name'] === 'Warranty');
    let tabs = Object.assign([], this.state.tabs);

    for (const tab of tabs) {
      switch (tab['name']) {
        case 'Configure':
          tab['content'] = /*#__PURE__*/React.createElement(Configure, {
            system: systemWithoutStandaloneBuckets,
            currentConfig: this.state.currentConfig,
            csrf: this.props.csrf,
            validateConfiguration: this.validateConfiguration,
            updateSystem: this.updateSystem,
            baseUrl: this.props.baseUrl,
            currencyFormatter: this.currencyFormatter
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
            system: systemWithOnlyStandaloneBuckets,
            currentConfig: this.state.currentConfig,
            csrf: this.props.csrf,
            updateSystem: this.updateSystem,
            validateConfiguration: this.validateConfiguration,
            currencyFormatter: this.currencyFormatter
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
            prepareConfiguration: this.prepareConfiguration,
            environmentId: this.props.environmentId,
            storeId: this.props.storeId,
            csrf: this.props.csrf,
            appsUrl: this.props.appsUrl,
            token: this.props.token,
            configuringSubKit: this.props.configuringSubKit,
            currencyFormatter: this.currencyFormatter
          });
          break;
      }
    }

    return /*#__PURE__*/React.createElement(React.Fragment, null, ('currentWarehouse' in this.props || 'currentPriceLevel' in this.props) && /*#__PURE__*/React.createElement("form", {
      className: "mb-3",
      method: "get"
    }, /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, 'currentWarehouse' in this.props && /*#__PURE__*/React.createElement("div", {
      className: "col-lg-3"
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
      className: "d-flex justify-content-center align-items-center p-5 h-100"
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
    }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", null, "Noise Level"), /*#__PURE__*/React.createElement("div", null, this.state.system['nose_level'])))), /*#__PURE__*/React.createElement("p", null, "Configure your system by selecting the desired item or items from each required parts category below.")), /*#__PURE__*/React.createElement("div", {
      className: "col-md-4 d-flex flex-column justify-content-center"
    }, this.state.validConfiguration ? /*#__PURE__*/React.createElement(React.Fragment, null, 'cost' in this.state.system ? [['CONFIGURED PRICE', this.currencyFormatter.format(this.state.system['price'])], ['COST', this.currencyFormatter.format(this.state.system['cost'])], ['GROSS MARGIN', this.state.system['gross_margin']]].map(([title, value]) => /*#__PURE__*/React.createElement("div", {
      className: "mb-1"
    }, /*#__PURE__*/React.createElement("h6", {
      className: "text-muted mb-0"
    }, title, ":"), /*#__PURE__*/React.createElement("h4", {
      className: "text-primary"
    }, value))) : /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("h5", {
      className: "text-muted"
    }, "CONFIGURED PRICE:"), /*#__PURE__*/React.createElement("h2", {
      className: "text-primary"
    }, this.currencyFormatter.format(this.state.system['price']))), /*#__PURE__*/React.createElement("div", {
      className: "text-muted"
    }, "From ", this.currencyFormatter.format(this.state.system['price']), "/mo")) : /*#__PURE__*/React.createElement("h4", {
      className: "text-primary"
    }, "Invalid Configuration"))))), /*#__PURE__*/React.createElement("div", {
      className: "container py-5"
    }, /*#__PURE__*/React.createElement("div", {
      className: "border-bottom"
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