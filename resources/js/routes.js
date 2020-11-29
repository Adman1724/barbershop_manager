import Home from './pages/Home';
import Login from './pages/Login';
import Register from './pages/Register'
import Test from './components/TestComponent'
import Employees from './pages/Employees'
import Payouts from './pages/Payouts'
import Users from './pages/Users'





export default[
    {
        path: '/',
        component: Home,
        name: 'home'
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/register',
        component: Register,
        name: 'register'
    },
    {
        path: '/test',
        component: Test,
        name: 'test'
    },
    {
        path: '/employees',
        component: Employees,
        name: 'employees'
    },
    {
        path: '/payouts',
        component: Payouts,
        name: 'payouts'
    },
    {
        path: '/users',
        component: Users,
        name: 'users'
    },


];
