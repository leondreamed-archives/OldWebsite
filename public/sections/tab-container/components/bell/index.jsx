class Bell extends React.Component {
  constructor(props) {
    super(props);
    this.toggleBanner = this.toggleBanner.bind(this);
  }
  render() {
    return (
      <img src ={"/sections/tab-container/components/bell/images/bell.png"} className="tab-container-bell" onClick={this.toggleBanner}/>
    );
  }

  toggleBanner() {
    $('.announcements-banner').slideToggle('fast');
  }
  
  
}

export { Bell };
