class Summary extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      comments: this.props.system?.['config_json']?.['comments'] ?? '',
      quantity: 1
    };
  }

  _updateComments(event) {
    this.setState({
      comments: event.target.value
    });
  }

  _updateQuantity(event) {
    this.setState({
      quantity: parseInt(event.target.value)
    });
  }

  _saveConfiguration() {
    this.saveConfigurationModal.fetchContent(this.props.baseUrl + '/system/save');
  }

  _emailConfiguration() {
    this.emailConfigurationModal.fetchContent(this.props.baseUrl + '/email/system');
  }

  _viewSpecs() {
    this.viewSpecsModal.fetchContent(this.props.baseUrl + '/system/specs');
  }

  _addToOrder() {
    this.props.saveConfiguration({
      quantity: this.state.quantity,
      comments: this.state.comments
    }, _ => {
      let url = this.props.baseUrl + ('cost' in this.props.system ? '/quotes' : '/order');

      if (this.props.subKitConfigId) {
        url = `${this.props.baseUrl}/system/${this.props.system['url']}/${this.props.configId}`;
      }

      window.location.assign(url);
    });
  }

  render() {
    let cards = [{
      image: '',
      title: 'Request Formal Quote',
      description: 'Use the Request Formal Quote tool to receive a formal quote based on this configuration. Please use the System Comments to note any changes or special requests you may have.',
      button: 'Request quote'
    }, {
      image: '',
      title: 'Submit For Review',
      description: "Are there any particular features that you're looking for? Is there a configuration option you want but isn't available online?",
      button: 'Submit for Review'
    }];
    let selectedSpecs = this.props.system['buckets'].filter(bucket => this.props.currentConfig[bucket['id']].filter(item => item['selected_at'] != null).length > 0).map(bucket => {
      let selectedItems = this.props.currentConfig[bucket['id']].filter(item => item['selected_at'] != null).map(item => (item['quantity'] > 1 ? `${item['quantity']} x ` : '') + item['name'] + (item['config_name'] ? ` (${item['config_name']})` : ''));
      return [bucket['category'], selectedItems.join('<br>')];
    });
    return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(Modal, {
      ref: modal => {
        this.saveConfigurationModal = modal;
      },
      id: "save-modal",
      size: "xl"
    }), /*#__PURE__*/React.createElement(Modal, {
      ref: modal => {
        this.emailConfigurationModal = modal;
      },
      id: "email-modal"
    }), /*#__PURE__*/React.createElement(Modal, {
      ref: modal => {
        this.viewSpecsModal = modal;
      },
      id: "specs-modal",
      size: "xl"
    }), !('cost' in this.props.system) && /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, cards.map(({
      image,
      title,
      description,
      button
    }) => /*#__PURE__*/React.createElement("div", {
      className: "col-md-6 mb-3 mb-md-0"
    }, /*#__PURE__*/React.createElement("div", {
      className: "d-flex flex-column align-items-center text-center bg-white p-5 h-100 shadow-sm"
    }, /*#__PURE__*/React.createElement("img", {
      src: image
    }), /*#__PURE__*/React.createElement("h3", {
      className: "mb-4"
    }, title), /*#__PURE__*/React.createElement("p", {
      className: "mb-4"
    }, description), /*#__PURE__*/React.createElement("a", {
      className: "btn btn-primary py-2 px-5 mt-auto",
      href: "javascript:void(0)"
    }, button))))), /*#__PURE__*/React.createElement("div", {
      className: "p-4 my-4 bg-white shadow-sm"
    }, /*#__PURE__*/React.createElement("table", {
      className: "table table-striped"
    }, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", {
      className: "d-flex"
    }, /*#__PURE__*/React.createElement("th", {
      className: "col-3"
    }, /*#__PURE__*/React.createElement("h5", {
      className: "mb-0 fw-bold"
    }, this.props.system['name'])), /*#__PURE__*/React.createElement("th", {
      className: "col-9"
    }, /*#__PURE__*/React.createElement("div", {
      className: "item-group justify-content-end align-items-end h-100"
    }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("span", {
      className: "h5 mb-0 icon-floppy"
    }), /*#__PURE__*/React.createElement("a", {
      className: "text-primary text-decoration-none fw-normal",
      href: "javascript:void(0)",
      "data-bs-toggle": "modal",
      "data-bs-target": "#save-modal",
      onClick: () => this._saveConfiguration()
    }, "Save Configuration")), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("span", {
      className: "h5 mb-0 icon-mail"
    }), /*#__PURE__*/React.createElement("a", {
      className: "text-primary text-decoration-none fw-normal",
      href: "javascript:void(0)",
      "data-bs-toggle": "modal",
      "data-bs-target": "#email-modal",
      onClick: () => this._emailConfiguration()
    }, "Email Configuration")), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("span", {
      className: "h5 mb-0 icon-print"
    }), /*#__PURE__*/React.createElement("a", {
      className: "text-primary text-decoration-none fw-normal",
      href: "javascript:void(0)",
      "data-bs-toggle": "modal",
      "data-bs-target": "#specs-modal",
      onClick: () => this._viewSpecs()
    }, "View Specs")))))), /*#__PURE__*/React.createElement("tbody", null, selectedSpecs.map(([bucketCategory, spec]) => /*#__PURE__*/React.createElement("tr", {
      className: "d-flex"
    }, /*#__PURE__*/React.createElement("td", {
      className: "col-3 fw-bold"
    }, bucketCategory), /*#__PURE__*/React.createElement("td", {
      className: "col-9",
      dangerouslySetInnerHTML: {
        __html: spec
      }
    })))))), /*#__PURE__*/React.createElement("div", {
      className: "bg-white shadow-sm p-4"
    }, /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-lg-8 col-md-6"
    }, /*#__PURE__*/React.createElement("h4", null, "System Comments"), /*#__PURE__*/React.createElement("p", null, "Please leave any further notes or comments pertaining to your system configuration below."), /*#__PURE__*/React.createElement("textarea", {
      className: "form-control",
      onChange: event => this._updateComments(event),
      rows: 5
    }, this.state.comments)), /*#__PURE__*/React.createElement("div", {
      className: "col-lg-4 col-md-6 d-flex flex-column justify-content-center"
    }, this.props.validConfiguration ? /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
      className: "text-md-end"
    }, /*#__PURE__*/React.createElement("div", {
      className: "h6"
    }, /*#__PURE__*/React.createElement("span", {
      className: "fw-bold"
    }, "Configured Price: "), /*#__PURE__*/React.createElement("span", {
      className: "h6"
    }, this.props.currencyFormatter.format(this.props.system['price']))), 'cost' in this.props.system && /*#__PURE__*/React.createElement("div", {
      className: "h6"
    }, /*#__PURE__*/React.createElement("span", {
      className: "fw-bold"
    }, "Cost: "), /*#__PURE__*/React.createElement("span", {
      className: "h6"
    }, this.props.currencyFormatter.format(this.props.system['cost']))), /*#__PURE__*/React.createElement("div", {
      className: "h6"
    }, /*#__PURE__*/React.createElement("label", {
      htmlFor: "quantity",
      className: "fw-bold"
    }, "Quantity:"), /*#__PURE__*/React.createElement("input", {
      id: "quantity",
      className: "d-inline-block form-control ms-1",
      type: "number",
      style: {
        width: "4rem"
      },
      name: "quantity",
      min: "1",
      defaultValue: this.state.quantity,
      onChange: event => this._updateQuantity(event)
    })), /*#__PURE__*/React.createElement("hr", {
      className: "border-black"
    }), /*#__PURE__*/React.createElement("div", {
      className: "h6"
    }, /*#__PURE__*/React.createElement("span", {
      className: "fw-bold"
    }, "Grand Total: "), /*#__PURE__*/React.createElement("span", {
      className: "h6"
    }, this.props.currencyFormatter.format(this.props.system['price'] * this.state.quantity))), 'cost' in this.props.system && /*#__PURE__*/React.createElement("div", {
      className: "h6"
    }, /*#__PURE__*/React.createElement("span", {
      className: "fw-bold"
    }, "Total Cost: "), /*#__PURE__*/React.createElement("span", {
      className: "h6"
    }, this.props.currencyFormatter.format(this.props.system['cost'] * this.state.quantity)))), /*#__PURE__*/React.createElement("a", {
      className: "btn btn-primary py-2 mt-1",
      href: "javascript:void(0)",
      onClick: () => this._addToOrder()
    }, /*#__PURE__*/React.createElement("span", {
      className: "h5 icon-plus"
    }), this.props.subKitConfigId ? 'Save & Return' : 'Add To Order')) : /*#__PURE__*/React.createElement("h4", {
      className: "text-primary text-md-center"
    }, "Invalid Configuration")))));
  }

}