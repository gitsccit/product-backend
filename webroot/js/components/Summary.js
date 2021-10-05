class Summary extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      comments: this.props.system?.['config_json']?.['comments'] ?? '',
      quantity: 1,
    };
  }

  _updateComments(event) {
    this.setState({
      comments: event.target.value,
    });
  }

  _updateQuantity(event) {
    this.setState({
      quantity: parseInt(event.target.value),
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
    this.props.updateConfiguration({quantity: this.state.quantity, comments: this.state.comments}, result => {
      let url = this.props.baseUrl + ('cost' in this.props.system ? '/sales/quotes' : '/order');

      if (this.props.subKitPath) {
        let path = this.props.subKitPath.split('.').slice(0, -4).join('.');
        path = path ? `/${btoa(path)}` : '';
        url = `${this.props.baseUrl}/system/${this.props.system['url']}/${this.props.identifier}${path}`;
      }

      window.location.assign(url);
    });
  }

  render() {
    let cards = [
      {
        image: '',
        title: 'Request Formal Quote',
        description: 'Use the Request Formal Quote tool to receive a formal quote based on this configuration. Please use the System Comments to note any changes or special requests you may have.',
        button: 'Request quote',
      },
      {
        image: '',
        title: 'Submit For Review',
        description: "Are there any particular features that you're looking for? Is there a configuration option you want but isn't available online?",
        button: 'Submit for Review',
      },
    ];

    let selectedSpecs = this.props.system['buckets']
      .filter(bucket => this.props.currentConfig[bucket['id']].filter(item => item['selected_at'] != null).length > 0)
      .map(bucket => {
        let selectedItems = this.props.currentConfig[bucket['id']]
          .filter(item => item['selected_at'] != null)
          .map(item => (item['quantity'] > 1 ? `${item['quantity']} x ` : '') + item['name'] + (item['config_name'] ? ` (${item['config_name']})` : ''));

        return [bucket['category'], selectedItems.join('<br>')];
      });

    return (
      <div>
        <Modal ref={(modal) => {
          this.saveConfigurationModal = modal;
        }} id="save-modal" size="xl"/>
        <Modal ref={(modal) => {
          this.emailConfigurationModal = modal;
        }} id="email-modal"/>
        <Modal ref={(modal) => {
          this.viewSpecsModal = modal;
        }} id="specs-modal" size="xl"/>
        {
          !('cost' in this.props.system) &&
          <div className="row">
            {
              cards.map(({image, title, description, button}) => (
                <div className="col-md-6 mb-3 mb-md-0">
                  <div className="d-flex flex-column align-items-center text-center bg-white p-5 h-100 shadow-sm">
                    <img src={image}/>
                    <h3 className="mb-4">{title}</h3>
                    <p className="mb-4">{description}</p>
                    <a className="btn btn-primary py-2 px-5 mt-auto" href="javascript:void(0)">{button}</a>
                  </div>
                </div>
              ))
            }
          </div>
        }
        <div className="p-4 my-4 bg-white shadow-sm">
          <table className="table table-striped">
            <thead>
            <tr className="d-flex">
              <th className="col-3">
                <h5 className="mb-0 fw-bold">{this.props.system['name']}</h5>
              </th>
              <th className="col-9">
                <div className="item-group justify-content-end align-items-end h-100">
                  <div>
                    <span className="h5 mb-0 icon-floppy"></span>
                    <a className="text-primary text-decoration-none fw-normal" href="javascript:void(0)"
                       data-bs-toggle="modal" data-bs-target="#save-modal"
                       onClick={() => this._saveConfiguration()}>Save
                      Configuration</a>
                  </div>
                  <div>
                    <span className="h5 mb-0 icon-mail"></span>
                    <a className="text-primary text-decoration-none fw-normal" href="javascript:void(0)"
                       data-bs-toggle="modal" data-bs-target="#email-modal"
                       onClick={() => this._emailConfiguration()}>
                      Email Configuration</a>
                  </div>
                  <div>
                    <span className="h5 mb-0 icon-print"></span>
                    <a className="text-primary text-decoration-none fw-normal" href="javascript:void(0)"
                       data-bs-toggle="modal" data-bs-target="#specs-modal"
                       onClick={() => this._viewSpecs()}>View Specs</a>
                  </div>
                </div>
              </th>
            </tr>
            </thead>
            <tbody>
            {
              selectedSpecs.map(([bucketCategory, spec]) => (
                <tr className="d-flex">
                  <td className="col-3 fw-bold">
                    {bucketCategory}
                  </td>
                  <td className="col-9" dangerouslySetInnerHTML={{__html: spec}}>
                  </td>
                </tr>
              ))
            }
            </tbody>
          </table>
        </div>
        <div className="bg-white shadow-sm p-4">
          <div className="row">
            <div className="col-lg-8 col-md-6">
              <h4>System Comments</h4>
              <p>Please leave any further notes or comments pertaining to your system configuration below.</p>
              <textarea className="form-control" onChange={event => this._updateComments(event)} rows={5}>
              {this.state.comments}
            </textarea>
            </div>
            <div className="col-lg-4 col-md-6 d-flex flex-column justify-content-center">
              {
                this.props.validConfiguration ?
                  <>
                    <div className="text-md-end">
                      <div className="h6">
                        <span className="fw-bold">Configured Price: </span>
                        <span className="h6">{this.props.currencyFormatter.format(this.props.system['price'])}</span>
                      </div>
                      {
                        'cost' in this.props.system &&
                        <div className="h6">
                          <span className="fw-bold">Cost: </span>
                          <span className="h6">{this.props.currencyFormatter.format(this.props.system['cost'])}</span>
                        </div>
                      }
                      <div className="h6">
                        <label htmlFor="quantity" className="fw-bold">Quantity:</label>
                        <input id="quantity" className="d-inline-block form-control ms-1" type="number"
                               style={{width: "4rem"}} name="quantity" min="1" defaultValue={this.state.quantity}
                               onChange={(event) => this._updateQuantity(event)}/>
                      </div>
                      <hr className="border-black"/>
                      <div className="h6">
                        <span className="fw-bold">Grand Total: </span>
                        <span className="h6">
                          {this.props.currencyFormatter.format(this.props.system['price'] * this.state.quantity)}</span>
                      </div>
                      {
                        'cost' in this.props.system &&
                        <div className="h6">
                          <span className="fw-bold">Total Cost: </span>
                          <span className="h6">
                            {this.props.currencyFormatter.format(this.props.system['cost'] * this.state.quantity)}
                          </span>
                        </div>
                      }
                    </div>
                    <a className="btn btn-primary py-2 mt-1" href="javascript:void(0)"
                       onClick={() => this._addToOrder()}>
                      <span
                        className="h5 icon-plus"></span>{this.props.subKitPath ? 'Save & Return' : 'Add To Order'}
                    </a>
                  </> :
                  <h4 className="text-primary text-md-center">
                    Invalid Configuration
                  </h4>
              }
            </div>
          </div>
        </div>
      </div>
    );
  }
}
