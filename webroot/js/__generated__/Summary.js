class Summary extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      grandTotal: props.system['price']
    };
  }

  _updateQuantity(event) {
    this.props.validateConfiguration(this.props.currentConfig, parseInt(event.target.value), result => {
      this.setState({
        grandTotal: result['price']
      });
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
      title: 'Request Formal Quote',
      description: 'Use the Request Formal Quote tool to receive a formal quote based on this configuration. Please use the System Comments to note any changes or special requests you may have.',
      button: 'Request quote'
    }];
    let selectedSpecs = this.props.system['buckets'].filter(bucket => this.props.currentConfig[bucket['id']].filter(item => item['selected_at'] != null).length > 0).map(bucket => {
      let selectedItems = this.props.currentConfig[bucket['id']].filter(item => item['selected_at'] != null).map(item => item['quantity'] > 1 ? `${item['quantity']} x ${item['name']}` : item['name']);
      return [bucket['category'], selectedItems.join('<br>')];
    });
    return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, cards.map(({
      image,
      title,
      description,
      button
    }) => /*#__PURE__*/React.createElement("div", {
      className: "col-md-6 mb-3 mb-md-0"
    }, /*#__PURE__*/React.createElement("div", {
      className: "d-flex flex-column align-items-center text-center bg-white p-5 h-100"
    }, /*#__PURE__*/React.createElement("img", {
      src: image
    }), /*#__PURE__*/React.createElement("h3", {
      className: "mb-4"
    }, title), /*#__PURE__*/React.createElement("p", {
      className: "mb-4"
    }, description), /*#__PURE__*/React.createElement("a", {
      className: "btn btn-primary py-2 px-5 mt-auto",
      href: "#"
    }, button))))), /*#__PURE__*/React.createElement("table", {
      className: "table table-bordered my-5"
    }, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", {
      className: "d-flex"
    }, /*#__PURE__*/React.createElement("th", {
      className: "col-3"
    }, /*#__PURE__*/React.createElement("h3", {
      className: "mb-0 fw-bold"
    }, this.props.system['name'])), /*#__PURE__*/React.createElement("th", {
      className: "col-9"
    }, /*#__PURE__*/React.createElement("div", {
      className: "item-group justify-content-end"
    }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("span", {
      className: "h5 mb-0 icon-floppy"
    }), /*#__PURE__*/React.createElement("a", {
      className: "text-primary text-decoration-none",
      href: "#"
    }, "Save Configuration")), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("span", {
      className: "h5 mb-0 icon-mail"
    }), /*#__PURE__*/React.createElement("a", {
      className: "text-primary text-decoration-none",
      href: "#"
    }, "Email Configuration")), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("span", {
      className: "h5 mb-0 icon-print"
    }), /*#__PURE__*/React.createElement("a", {
      className: "text-primary text-decoration-none",
      href: "#"
    }, "View Specs")))))), /*#__PURE__*/React.createElement("tbody", null, selectedSpecs.map(([bucketCategory, spec]) => /*#__PURE__*/React.createElement("tr", {
      className: "d-flex"
    }, /*#__PURE__*/React.createElement("td", {
      className: "col-3 fw-bold"
    }, bucketCategory), /*#__PURE__*/React.createElement("td", {
      className: "col-9",
      dangerouslySetInnerHTML: {
        __html: spec
      }
    }))))), /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-lg-8 col-md-6"
    }, /*#__PURE__*/React.createElement("h4", null, "System Comments"), /*#__PURE__*/React.createElement("p", null, "Please leave any further notes or comments pertaining to your system configuration below."), /*#__PURE__*/React.createElement("textarea", {
      className: "form-control",
      name: "comments",
      id: "comments",
      rows: 5
    })), /*#__PURE__*/React.createElement("div", {
      className: "col-lg-4 col-md-6 d-flex flex-column justify-content-between"
    }, /*#__PURE__*/React.createElement("div", {
      className: "text-md-right"
    }, /*#__PURE__*/React.createElement("div", {
      className: "h5"
    }, /*#__PURE__*/React.createElement("span", null, "Configured Price: "), /*#__PURE__*/React.createElement("span", {
      className: "h4 fw-bold"
    }, this.props.system['price'])), /*#__PURE__*/React.createElement("div", {
      className: "h5"
    }, /*#__PURE__*/React.createElement("label", {
      htmlFor: "quantity"
    }, "Quantity: "), /*#__PURE__*/React.createElement("input", {
      id: "quantity",
      className: "d-inline-block form-control",
      type: "number",
      style: {
        width: "4rem"
      },
      name: "quantity",
      min: "1",
      defaultValue: "1",
      onChange: event => this._updateQuantity(event)
    })), /*#__PURE__*/React.createElement("hr", {
      className: "border-black"
    }), /*#__PURE__*/React.createElement("div", {
      className: "h5"
    }, /*#__PURE__*/React.createElement("span", null, "Grand Total: "), /*#__PURE__*/React.createElement("span", {
      className: "h4 fw-bold"
    }, this.state.grandTotal))), /*#__PURE__*/React.createElement("a", {
      className: "btn btn-primary py-2"
    }, /*#__PURE__*/React.createElement("span", {
      className: "h5 icon-plus-circled"
    }), "Add To Order"))));
  }

}