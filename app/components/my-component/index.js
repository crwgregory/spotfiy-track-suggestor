
window.Index = {
  // Do the Vue

  el: '#spotify-track-suggester',

  components: {
    'spotify-track-suggester-component': require('./index.vue')
  }
};
Vue.ready(window.Index);
