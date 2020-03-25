import { Tab } from './components/tab/index.js';
import { Logo } from './components/logo/index.js';
import { User } from './components/user/index.js';
import { Bell } from './components/bell/index.js';

class TabContainer extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      tabs: [
        {href: '/pages/articles/index.php', name: 'Articles'},
        {href: '/pages/updatelog/index.php', name: 'Update Log'},
        {href: '/pages/others/index.php', name: 'Others'}
      ]
    }
  }

  render() {
    return (
      <div className='tab-container'>
        <Logo />
        {this.state.tabs.map(tab => (
          <Tab href={tab.href}>{tab.name}</Tab>
        ))}
        <div className='tab-container-icons'>
          <Bell />
        </div>
      </div>
    );
  }
}

ReactDOM.render(<TabContainer/>, $('#_tab-container').get(0));