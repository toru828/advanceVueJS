import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import UsersList from '@/components/user/UsersList'
import EditForm from '@/components/user/EditForm'
import AddForm from '@/components/user/AddForm';
import SearchForm from '@/components/user/SearchForm';

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Login',
      component: Login
    },
    {
      path: '/users',
      name: 'UsersList',
      component: UsersList
    },
    {
      path: '/edit/:id',
      name: 'EditForm',
      component: EditForm
    },
    {
      path: '/add',
      name: 'AddForm',
      component: AddForm
    },
    {
      path: '/search',
      name: 'SearchForm',
      component: SearchForm
    }
  ]
})
