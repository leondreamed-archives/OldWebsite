class HomePageIntroduction extends React.Component {
  render() {
    return (
      <div className="home-page-introduction">
        {this.props.children}
      </div>
    )
  }
}

let myIntro = "Hey! I'm Leon, and I love to learn. On my website, you can find tips and tricks I use to my improve my learning process. I try to write one new article every week and add a new feature every month. I hope you get something new out of my site!"

let MyHomePageIntroduction = (
  <HomePageIntroduction>
    {myIntro}
  </HomePageIntroduction>
);

ReactDOM.render(MyHomePageIntroduction, $('#_home-page-introduction').get(0));