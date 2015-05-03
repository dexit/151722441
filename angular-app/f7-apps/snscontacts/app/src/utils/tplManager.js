define([], function () {
  'use strict';

  var $$ = Dom7;
  var t7 = Template7;

  var tplManager = {

    /**
     * Init for template manager.
     *
     * @return void
     */
    init: function () {
      /*$$('body').append(GTPL);*/
    },

    /**
     * Load template by id
     *
     * @param id
     * @returns {*}
     */
    loadTpl: function (id) {
      var tpl = $$('#' + id).html();
      return tpl;
    },

    /**
     * Render template by name.
     *
     * @param tplName
     * @param renderData
     * @param callback
     */
    renderRemoteTpl: function (tplName, renderData, callback) {
      tplName = tplName || '';
      $$.get('pages/' + tplName + '.tpl.html', function (markup) {
        var compiledTemplate = t7.compile(markup);
        var output = compiledTemplate(renderData);

        typeof(callback === 'function') ? callback(output) : null;
      });

    },

    /**
     * Render template.
     *
     * @param markup
     * @param renderData
     * @returns {*}
     */
    renderTpl: function (markup, renderData) {
      var compiledTemplate = t7.compile(markup);
      var output = compiledTemplate(renderData);
      return output;
    },

    /**
     * Render template by id
     *
     * @param tplId
     * @param renderData
     * @returns {*}
     */
    renderTplById: function (tplId, renderData) {
      var markup = this.loadTpl(tplId);
      var compiledTemplate = t7.compile(markup);
      var output = compiledTemplate(renderData);
      return output;
    }

  };

  tplManager.init();

  return tplManager;
});