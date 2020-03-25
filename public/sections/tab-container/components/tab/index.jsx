class Tab extends React.Component {
  render() {
    return (
      <a className='tab-container-tab'
      href={this.props.href}>
        {this.props.children}
      </a>
    );
  }
}

export { Tab };