/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2018 ${ORGANIZATION}.
 * @license    __LICENSE__
 */

($ => {
  class PhoenixForm extends PhoenixJQueryPlugin {
    static get is() {
      return 'Form';
    }

    static get proxies() {
      return {
        form: 'createPlugin'
      };
    }

    /**
     * Plugin name.
     * @returns {string}
     */
    static get pluginName() {
      return 'form';
    }

    static get pluginClass() {
      return PhoenixFormElement;
    }

    /**
     * Default options.
     * @returns {Object}
     */
    static get defaultOptions() {
      return {};
    }
  }

  class PhoenixFormElement {
    /**
     * Constructor.
     * @param {jQuery}      $form
     * @param {Object}      options
     * @param {PhoenixCore} phoenix
     */
    constructor($form, options, phoenix) {
      // If form not found, create one
      if ($form.length === 0) {
        $form = $('<form>');

        if (options.mainSelector.indexOf('#') === 0) {
          $form.attr('id', options.mainSelector.substr(1));
          $form.attr('name', options.mainSelector.substr(1));
        }

        $form.attr('action', 'post');
        $form.attr('enctype', 'multipart/form-data');
        $form.attr('novalidate', 'true');
        $form.attr('action', phoenix.data('phoenix.uri')['full']);
        $form.css('display', 'none');

        const $csrf = $('<input type="hidden" value="" name="">');
        $csrf.attr('name', phoenix.data('csrfToken'));

        $form.append($csrf);

        $('body').append($form);
      }

      options = $.extend(true, {}, this.constructor.defaultOptions, options);

      this.form = $form;
      this.options = options;

      this.bindEvents();
    }

    bindEvents() {
      if (this.form.attr('data-toolbar')) {
        $(this.form.attr('data-toolbar')).find('*[data-action]').on('click', (e) => {
          this.form.trigger('phoenix.submit', e.currentTarget);
        });
      }

      this.form.on('phoenix.submit', (e, button) => {
        const $button = $(button);
        const action = $button.attr('data-action');
        const target = $button.attr('data-target') || null;
        const query = $button.data('query') || {};
        query['task'] = $button.attr('data-task') || null;

        this[action](target, query);
      });
    }

    /**
     * Make a request.
     *
     * @param  {string} url
     * @param  {Object} queries
     * @param  {string} method
     * @param  {string} customMethod
     *
     * @returns {boolean}
     */
    submit(url, queries, method, customMethod) {
      const form = this.form;

      if (customMethod) {
        let methodInput = form.find('input[name="_method"]');

        if (!methodInput.length) {
          methodInput = $('<input name="_method" type="hidden">');

          form.append(methodInput);
        }

        methodInput.val(customMethod);
      }

      // Set queries into form.
      if (queries) {
        let input;

        const flatted = this.constructor.flattenObject(queries);

        $.each(flatted, (key, value) => {
          const fieldName = this.constructor.buildFieldName(key);
          input = form.find('input[name="' + fieldName + '"]');

          if (!input.length) {
            input = $('<input name="' + fieldName + '" type="hidden">');

            form.append(input);
          }

          input.val(value);
        });
      }

      if (url) {
        form.attr('action', url);
      }

      if (method) {
        form.attr('method', method);
      }

      form.submit();

      return true;
    }

    /**
     * Make a GET request.
     *
     * @param  {string} url
     * @param  {Object} queries
     * @param  {string} customMethod
     *
     * @returns {boolean}
     */
    get(url, queries, customMethod) {
      return this.submit(url, queries, 'GET', customMethod);
    }

    /**
     * Post form.
     *
     * @param  {string} url
     * @param  {Object} queries
     * @param  {string} customMethod
     *
     * @returns {boolean}
     */
    post(url, queries, customMethod) {
      customMethod = customMethod || 'POST';

      return this.submit(url, queries, 'POST', customMethod);
    }

    /**
     * Make a PUT request.
     *
     * @param  {string} url
     * @param  {Object} queries
     *
     * @returns {boolean}
     */
    put(url, queries) {
      return this.post(url, queries, 'PUT');
    }

    /**
     * Make a PATCH request.
     *
     * @param  {string} url
     * @param  {Object} queries
     *
     * @returns {boolean}
     */
    patch(url, queries) {
      return this.post(url, queries, 'PATCH');
    }

    /**
     * Make a DELETE request.
     *
     * @param  {string} url
     * @param  {Object} queries
     *
     * @returns {boolean}
     */
    sendDelete(url, queries) {
      return this['delete'](url, queries);
    }

    /**
     * Make a DELETE request.
     *
     * @param  {string} url
     * @param  {Object} queries
     *
     * @returns {boolean}
     */
    delete(url, queries) {
      return this.post(url, queries, 'DELETE');
    }

    /**
     * @see https://stackoverflow.com/a/53739792
     *
     * @param {Object} ob
     * @returns {Object}
     */
    static flattenObject(ob) {
      const toReturn = {};

      for (let i in ob) {
        if (!ob.hasOwnProperty(i)) {
          continue;
        }

        if ((typeof ob[i]) === 'object' && ob[i] != null) {
          const flatObject = this.flattenObject(ob[i]);

          for (let x in flatObject) {
            if (!flatObject.hasOwnProperty(x)) {
              continue;
            }

            toReturn[i + '/' + x] = flatObject[x];
          }
        } else {
          toReturn[i] = ob[i];
        }
      }
      return toReturn;
    }

    static buildFieldName(field) {
      const names = field.split('/');

      const first = names.shift();

      return first + names.map(name => `[${name}]`).join('');
    }
  }

  window.PhoenixForm = PhoenixForm;
})(jQuery);
