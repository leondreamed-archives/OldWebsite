class SiteFooterLink extends React.Component {
  render() {
    return (
      <div className="site-footer-link-wrapper">
        <a className="site-footer-link" href={this.props.href}>
          {this.props.children}
        </a>
      </div>
    );
  }
}

class SiteFooterSection extends React.Component {
  render() {
    return (
      <div className="site-footer-section">
        <div className="site-footer-title">{this.props.title}</div>
        {this.props.children}
      </div>
    );
  }
}

class SiteFooter extends React.Component {
  render() {
    return (
      <div className="site-footer">
        <picture className="site-footer-background-picture">
          <source srcSet={_root+'/images/background.webp'} type="image/webp" />
          <source srcSet={_root+'/images/background.png'} type="image/png" />
          <img className="site-footer-background-img" src={_root+"/images/background.webp"} />
        </picture>
        {this.props.children}
      </div>
    );
  }
}

const timeLoggerURL = "https://docs.google.com/spreadsheets/d/1N69GtA6hKS8vg77rJm-12OJihQihVyvWPkg6ZFk827U/edit?usp=sharing"

const MySiteFooter = (
<SiteFooter>
  <SiteFooterSection title="Meta Links">
    <SiteFooterLink href="#_tab-container">Back To Top</SiteFooterLink>
    <SiteFooterLink href="https://github.com/leonzalion/website">GitHub Page</SiteFooterLink>
  </SiteFooterSection>
  <SiteFooterSection title="Accounts">
    <SiteFooterLink href="https://twitter.com/leonzalion/">Twitter</SiteFooterLink>
    <SiteFooterLink href="https://twitch.tv/leonzalion/">Twitch</SiteFooterLink>
    <SiteFooterLink href="https://goodreads.com/leonzalion">Goodreads</SiteFooterLink>
  </SiteFooterSection>
  <SiteFooterSection title="Accountability">
    <SiteFooterLink href={timeLoggerURL}>TimeLogger</SiteFooterLink>
  </SiteFooterSection>
</SiteFooter>
);

ReactDOM.render(MySiteFooter, $('#_site-footer').get(0));
