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

  fetchContent(url = null) {
    this.setState({
      html: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
    }, () => {
      fetch(url, {
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
      className: `modal-dialog modal-dialog-centered justify-content-center ${this.props.size != null && `modal-${this.props.size}`}`,
      dangerouslySetInnerHTML: {
        __html: this.state.html
      }
    }));
  }

}