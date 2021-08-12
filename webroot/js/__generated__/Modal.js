/**
 * Modal component requires `id`, `url`. Change `url` to fetch the content.
 */
class Modal extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      html: undefined
    };
  }

  componentDidUpdate(prevProps) {
    if (this.props.url !== prevProps.url) {
      this._fetchContent();
    }
  }

  _fetchContent() {
    this.setState({
      html: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
    }, () => {
      fetch(this.props.url, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }).then(response => response.text()).then(result => {
        this.setState({
          html: result
        });
      });
    });
  }

  render() {
    return /*#__PURE__*/React.createElement("div", {
      className: "modal fade",
      tabIndex: "-1",
      id: this.props.id,
      "aria-hidden": "true"
    }, /*#__PURE__*/React.createElement("div", {
      className: `modal-dialog modal-dialog-centered modal-dialog-scrollable justify-content-center ${this.props.size != null && `modal-${this.props.size}`}`,
      dangerouslySetInnerHTML: {
        __html: this.state.html
      }
    }));
  }

}