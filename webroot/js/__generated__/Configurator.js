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
          item['selected_at'] = null;
          item['quantity'] = parseInt(bucket['quantity'][0]);
          system['system_items'].forEach(entry => {
            if (item['id'] === entry['item_id']) {
              item['selected_at'] = Date.now();
              item['quantity'] = parseInt(entry['quantity']);
            }
          });
          bucketItems.push(item);
        });
      });
      baseConfig[bucket['id']] = bucketItems;
    });
    this.validateConfiguration = this.validateConfiguration.bind(this);
    this.updateSystem = this.updateSystem.bind(this);
    this.state = {
      system: system,
      tabs: JSON.parse(props.tabs),
      currentConfig: baseConfig,
      currentTab: 0,
      validConfiguration: true
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
      currentTab: Math.min(this.state.tabs.length - 1, this.state.currentTab + 1)
    });
  }

  _getBaseUrl() {
    let url = window.location.href;
    let index = url.indexOf('/system');
    return url.substr(0, index);
  }

  validateConfiguration(system, newConfig, quantity, callback) {
    let selectedBucketObjects = Object.entries(this.state.currentConfig).map(([bucketID, items]) => {
      let selectedItems = items.filter(item => {
        return item['selected_at'] != null;
      }).map(item => {
        return {
          [item['id']]: item['quantity']
        };
      });
      selectedItems = Object.assign({}, ...selectedItems);
      return [bucketID, selectedItems];
    }).filter(([, selectedItems]) => {
      return Object.keys(selectedItems).length > 0;
    });
    let configuration = Object.fromEntries(selectedBucketObjects);
    let payload = {
      system: system['id'],
      kit: system['kit_id'],
      configuration: configuration
    };
    let url = this._getBaseUrl() + '/system/validate';
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
    let tabs = [{
      name: 'Configure',
      description: 'Configure you system by selecting the desired item or items from each required category below.',
      content: /*#__PURE__*/React.createElement(Configure, {
        system: systemWithoutStandaloneBuckets,
        currentConfig: this.state.currentConfig,
        csrf: this.props.csrf,
        validateConfiguration: this.validateConfiguration,
        updateSystem: this.updateSystem,
        baseUrl: this._getBaseUrl()
      })
    }, {
      name: 'Storage Setup',
      description: 'Assign the storage distribution to your controllers from the chosen drives you selected.',
      content: /*#__PURE__*/React.createElement(StorageSetup, {
        system: this.state.system,
        currentConfig: this.state.currentConfig
      })
    }, {
      name: 'Select Warranty',
      description: 'Select the warranty.',
      content: /*#__PURE__*/React.createElement(Configure, {
        system: systemWithOnlyStandaloneBuckets,
        currentConfig: this.state.currentConfig,
        csrf: this.props.csrf,
        validateConfiguration: this.validateConfiguration
      })
    }, {
      name: 'Summary',
      description: 'Review the following and check for any errors or mistakes. You may also Print, Email, or Save this configuration for future review.',
      content: /*#__PURE__*/React.createElement(Summary, {
        system: this.state.system,
        currentConfig: this.state.currentConfig,
        validateConfiguration: this.validateConfiguration
      })
    }];
    return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
      className: "bg-white"
    }, /*#__PURE__*/React.createElement("div", {
      className: "container py-5"
    }, /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-md-4"
    }, /*#__PURE__*/React.createElement("div", {
      className: "d-flex justify-content-center align-items-center p-5 h-100"
    }, /*#__PURE__*/React.createElement("img", {
      className: "mw-100 mh-100",
      src: this.state.system['image']
    }))), /*#__PURE__*/React.createElement("div", {
      className: "col-md-4 d-flex flex-column justify-content-center"
    }, /*#__PURE__*/React.createElement("h1", {
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
    }, /*#__PURE__*/React.createElement("div", {
      className: "h4 text-muted"
    }, "CONFIGURED PRICE:"), /*#__PURE__*/React.createElement("h1", {
      className: "text-primary"
    }, this.state.validConfiguration ? this.state.system['price'] : 'Invalid Configuration'), /*#__PURE__*/React.createElement("div", {
      className: "text-muted"
    }, "From ", this.state.system['price'], "/mo"))))), /*#__PURE__*/React.createElement("div", {
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
      className: "text-decoration-none",
      href: "javascript:void(0)",
      onClick: () => this._back()
    }, /*#__PURE__*/React.createElement("span", {
      className: "bg-primary text-white p-1 icon-left-open me-2"
    }), "Go Back"), /*#__PURE__*/React.createElement("a", {
      className: "text-decoration-none",
      href: "javascript:void(0)",
      onClick: () => this._continue()
    }, "Continue", /*#__PURE__*/React.createElement("span", {
      className: "bg-primary text-white p-1 icon-right-open ms-2"
    })))));
  }

}

const configurator = document.getElementById('configurator');
ReactDOM.render( /*#__PURE__*/React.createElement(Configurator, configurator.dataset), configurator);