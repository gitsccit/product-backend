class Summary extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      grandTotal: props.system['price'],
    };
  }

  _updateQuantity(event) {
    this.props.validateConfiguration(this.props.system, this.props.currentConfig, parseInt(event.target.value), (result) => {
      this.setState({
        grandTotal: result['price'],
      });
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
        title: 'Request Formal Quote',
        description: 'Use the Request Formal Quote tool to receive a formal quote based on this configuration. Please use the System Comments to note any changes or special requests you may have.',
        button: 'Request quote',
      },
    ];

    let selectedSpecs = this.props.system['buckets']
      .filter(bucket => this.props.currentConfig[bucket['id']].filter(item => item['selected_at'] != null).length > 0)
      .map(bucket => {
        let selectedItems = this.props.currentConfig[bucket['id']]
          .filter(item => item['selected_at'] != null)
          .map(item => item['quantity'] > 1 ? `${item['quantity']} x ${item['name']}` : item['name']);

        return [bucket['category'], selectedItems.join('<br>')];
      });

    return (
      <div>
        {
          !('cost' in this.props.system) &&
          <div className="row">
            {
              cards.map(({image, title, description, button}) => (
                <div className="col-md-6 mb-3 mb-md-0">
                  <div className="d-flex flex-column align-items-center text-center bg-white p-5 h-100">
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
        <table className="table table-bordered my-5">
          <thead>
          <tr className="d-flex">
            <th className="col-3">
              <h3 className="mb-0 fw-bold">{this.props.system['name']}</h3>
            </th>
            <th className="col-9">
              <div className="item-group justify-content-end">
                <div>
                  <span className="h5 mb-0 icon-floppy"></span>
                  <a className="text-primary text-decoration-none" href="javascript:void(0)">Save Configuration</a>
                </div>
                <div>
                  <span className="h5 mb-0 icon-mail"></span>
                  <a className="text-primary text-decoration-none" href="javascript:void(0)">Email Configuration</a>
                </div>
                <div>
                  <span className="h5 mb-0 icon-print"></span>
                  <a className="text-primary text-decoration-none" href="javascript:void(0)">View Specs</a>
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
        <div className="row">
          <div className="col-lg-8 col-md-6">
            <h4>System Comments</h4>
            <p>Please leave any further notes or comments pertaining to your system configuration below.</p>
            <textarea className="form-control" name="comments" id="comments" rows={5}></textarea>
          </div>
          <div className="col-lg-4 col-md-6 d-flex flex-column justify-content-between">
            <div className="text-md-right">
              <div className="h5">
                <span>Configured Price: </span>
                <span
                  className="h4 fw-bold">{this.props.system['price']}</span>
              </div>
              <div className="h5">
                <label htmlFor="quantity">Quantity: </label>
                <input id="quantity" className="d-inline-block form-control" type="number"
                       style={{width: "4rem"}} name="quantity" min="1" defaultValue="1"
                       onChange={(event) => this._updateQuantity(event)}/>
              </div>
              <hr className="border-black"/>
              <div className="h5">
                <span>Grand Total: </span>
                <span
                  className="h4 fw-bold">{this.state.grandTotal}</span>
              </div>
            </div>
            <a className="btn btn-primary py-2" href="javascript:void(0)">
              <span className="h5 icon-plus-circled"></span>Add To Order
            </a>
          </div>
        </div>
      </div>
    );
  }
}
