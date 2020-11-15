import Home from './pages/Home';
import Login from './pages/Login';
import Register from './pages/Register'
import Test from './components/TestComponent'





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


];