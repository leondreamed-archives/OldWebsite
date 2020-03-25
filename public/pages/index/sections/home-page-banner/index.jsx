class HomePageBanner extends React.Component {
  render() {
    return (
    <div className='home-page-banner'>
      <h1 className='title'>
        {this.props.title}
      </h1>
      <p className='subtitle' dangerouslySetInnerHTML={{__html: this.props.subtitle}}>
      </p>
    </div>
    );
  }
}

let sayings = [
  {
    title: 'Become More Efficient',
    subtitle: `&ldquo;Progress isn&rsquo;t made by early risers. It&rsquo;s made by lazy men trying to find easier ways to do something.&rdquo; - Robert Heinlein`
  },
  {
    title: 'Grow In Knowledge',
    subtitle: `&ldquo;I did then what I knew how to do. Now that I know better, I do better.&rdquo; - Maya Angelou`
  },
  {
    title: 'Learn Without End',
    subtitle: `&ldquo;Live as if you were to die tomorrow. Learn as if you were to live forever.&rdquo; - Mahatma Gandhi`
  }
];

let randomSaying = sayings[Math.floor(Math.random() * sayings.length)];
let randomTitle = randomSaying.title;
let randomSubtitle = randomSaying.subtitle;

ReactDOM.render(
<HomePageBanner title={randomTitle} subtitle={randomSubtitle} />,
$('#_home-page-banner').get(0));
