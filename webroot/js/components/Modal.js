/**
 * Modal component requires `id`, `url`. Change `url` to fetch the content.
 */
class Modal extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      html: undefined,
      requestFailed: false,
    };
  }

  componentDidUpdate(prevProps) {
    if (this.props.url !== prevProps.url || this.state.requestFailed) {
      this._fetchContent();
    }
  }

  _fetchContent() {
    this.setState({
      html: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
    }, () => {
      fetch(this.props.url, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        }
      })
        .then(response => {
          this.setState({
            html: response.text(),
            requestFailed: !response.ok,
          });
        });
    });
  }

  render() {
    return (
      <div className="modal fade" tabIndex="-1" id={this.props.id} aria-hidden="true">
        <div
          className={`modal-dialog modal-dialog-centered modal-dialog-scrollable justify-content-center ${this.props.size != null && `modal-${this.props.size}`}`}>
          <div className="modal-content overflow-auto" dangerouslySetInnerHTML={{__html: this.state.html}}/>
        </div>
      </div>
    );
  }
}