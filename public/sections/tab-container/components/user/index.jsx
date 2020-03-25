class User extends React.Component {
  constructor(props) {
    super(props);

    this.displayUserMenu = this.displayUserMenu.bind(this);
    this.state = {
      src: "/sections/tab-container/components/user/images/hourglass.png",
      className: "tab-container-hourglass",
      loggedIn: false
    }

    let self = this;
    $.post("/account/scripts/getaccount.php", function(data) {
      data = JSON.parse(data);
      if (Object.keys(data).length === 0) {
        self.setState({
          src: "/sections/tab-container/components/user/images/login-circle.png",
          className: "tab-container-login",
          loggedIn: false
        });
      } else {
        self.setState({
          src: "/sections/tab-container/components/user/images/user.png",
          className: "tab-container-user",
          loggedIn: true
        });
      }
    });
  }
  render() {
    return (
      <div className="tab-container-account">
        <img src ={this.state.src} className={this.state.className} onClick={this.displayUserMenu}/>
      </div>
    );
  }
  displayUserMenu() {
    if (this.state.loggedIn) {
      console.log('logged in!');
    } else {
      window.location.href = "/pages/login/index.php";
    }
  }
}

export { User };
