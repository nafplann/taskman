// Start importing vendor js
// window.moment = require('moment-timezone');
window.swal = require('sweetalert2');
require('./plugins/nestable/jquery.nestable');

// Start importing page modules
import App from './helper';
import Dashboard from './dashboard';
import Project from './project';

window.App = App;
window.Dashboard = Dashboard;
window.Project = Project;