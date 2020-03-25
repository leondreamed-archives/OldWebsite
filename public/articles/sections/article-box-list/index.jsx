class ArticleBox extends React.Component {
  render() {
    let article = this.props.article;
    return (
      <a className='article-box' href={`${article.root}/english/index.php`}>
        <picture>
          <source srcSet={article.root + '/images/thumbnail.webp'} type="image/webp" />
          <source srcSet={article.root + '/images/thumbnail.jpeg'} type="image/jpeg" />
          <img src={article.root + '/images/thumbnail.jpeg'} alt={article.title} className='img'/>
        </picture>
        <div className='info'>
          <h1 className='title'>
            {article.title}
          </h1>
          <p className='desc' dangerouslySetInnerHTML={{__html: article.desc}}></p>
        </div>
      </a>
    );
  }
}

class ArticleBoxList extends React.Component {
  constructor(props) {
    super(props);
    this.state = {articles: []};
    $(function() {
      $('head').append("<link href='/articles/sections/article-box-list/index.css' rel='preload' as='style' type='text/css'/>" +
      "<link href='/articles/sections/article-box-list/index.css' rel='stylesheet' type='text/css'/>");
    });

    let articleBoxes = [];
    let self = this;
    $.post("/articles/scripts/get-all-articles.php", function(articles) {
      articles = JSON.parse(articles);
      let articleKeys = Object.keys(articles);
      let numArticles = self.props.numArticles;
      if (numArticles === undefined) numArticles = Infinity;
      for (let a, i = 0; i < Math.min(articleKeys.length, numArticles); ++i) {
        a = articles[articleKeys[i]];
        articleBoxes.push(<ArticleBox article={a} key={i} />);
      }
      self.setState({articles: articleBoxes});
    });
  }

  render() {
    return (
      <div className="article-box-list">
        {this.state.articles}
      </div>
    );
  }
}

export { ArticleBoxList };