require('./utils/helpers');
require('url-parse');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');
require('./prototypes');
require('./location');

require('react-filter-search');
/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
require('./components/domain_components/DomainAccount');
require('./components/domain_components/DomainAccounts');
require('./components/ServerMonitors');
require('./components/SingleServerMonitor');
require('./components/GodaddyDomainAccounts');
require('./components/domain_components/DomainRecords');
require('./components/AuthUser');

require('./components/security_components/RolesAndPermissions');

require('./components/account_components/AccountMain');
require("./components/account_components/AccountUserMain");