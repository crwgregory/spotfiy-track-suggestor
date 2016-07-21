
<?php $view->script('index', 'spotify-track-suggester:app/bundle/index.js', ['vue']); ?>
<?php $view->style('analyze-css', 'spotify-track-suggester:app/assets/styles/index.css'); ?>

<div id="spotify-track-suggester">
  <div class="uk-panel">
    Your module has been created. Run <code>npm install</code> then <code>webpack</code> in the package directory to compile the javascript.
  </div>
  <spotify-track-suggester-component></spotify-track-suggester-component>
</div>