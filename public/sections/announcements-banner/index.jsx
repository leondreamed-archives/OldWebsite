import { AnnouncementBox } from "/components/tweets/announcement-box.js";

class Announcements extends React.Component {
  constructor(props) {
    super(props);
    this.state = {tweets: []};

    var timezone_offset_minutes = new Date().getTimezoneOffset();
    timezone_offset_minutes = -timezone_offset_minutes;

    $.post("/scripts/tweets/get-announcements.php", {timezone_offset_minutes: timezone_offset_minutes}, function (data) {
      data = JSON.parse(data);
      console.log(data);
      let tweets = [];
      for (let i = 0; i < data.length; ++i) {
        tweets.push(data[i]);
      }
      this.addTweets(tweets);
      
    }.bind(this));

    this.bannerRef = React.createRef();
    
    this.addTweets = this.addTweets.bind(this);
  }

  addTweets(tweets) {
    for (let i = 0; i < tweets.length; ++i) {
      let tweetBoxRef = React.createRef();
      let tweetBox = <AnnouncementBox date={tweets[i].created_at} content={tweets[i].text} ref={tweetBoxRef}/>;
      console.log(tweetBoxRef.current);
      console.log(this.bannerRef.current);
      
      
    }
  }

  render() {
    return (
      <div className="announcements-banner" style={{display: 'none'}} ref={this.bannerRef}>
        
      </div>
    );
  }
}


ReactDOM.render(<Announcements />, $('#_announcements-banner').get(0));