/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2018 ${ORGANIZATION}.
 * @license    __LICENSE__
 */

(() => {
  const PhoenixSwitch = window.PhoenixSwitch = {
    name: 'phoenix-switch',
    template: `
<label class="phoenix-switch" :for="idName" :class="[size ? 'switch-' + size : '']">
    <input :id="idName + '-unchecked'" :name="name" type="hidden"
        :value="falseValue"
        :disabled="disabled"
    />
    <input type="checkbox" :name="name" :id="idName" class="form-control" :class="classes"
        :true-value="trueValue" :false-value="falseValue" :disabled="disabled"
        :value="trueValue"
        :checked="currentValue == trueValue"
        @change="changed"
        @click="click">
    <span
        class="switch-slider"
        :class="['slider-' + shape, color ? 'btn-' + color : 'btn-default']"
    ></span>
</label>
    `,
    data() {
      return {
        idName: '',
        currentValue: null
      }
    },
    props: {
      id: String,
      classes: String,
      value: null,
      name: String,
      disabled: Boolean,
      trueValue: {
        default: '1'
      },
      falseValue: {
        default: '0'
      },
      size: {
        type: String,
        default: 'default'
      },
      color: {
        type: String,
        default: 'primary'
      },
      shape: {
        type: String,
        default: 'square'
      }
    },
    created() {
      this.idName = this.id;

      if (!this.idName) {
        if (this.name) {
          this.idName = 'input-' + this.getDashedName();
        } else {
          this.idName = 'input-switch-' + new Date().getTime()
            + '-' + (Math.random() * 10000000000000000).toString();
        }
      }

      this.currentValue = this.value;
    },
    methods: {
      getDashedName() {
        return this.name.replace(/\[/g, '-').replace(/]/, '');
      },
      changed($event) {
        this.currentValue = $event.srcElement.checked ? this.trueValue : this.falseValue;
      },
      click($event) {
        this.$emit('click', $event);
      }
    },
    watch: {
      currentValue() {
        this.$emit('input', this.currentValue);
        this.$emit('change', this.currentValue);
      },

      value() {
        this.currentValue = this.value;
      }
    }
  };

  if (typeof window.Vue !== 'undefined') {
    window.Vue.component('phoenix-switch', PhoenixSwitch);
  }
})();
