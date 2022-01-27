<template>
    <div class="w-100">
        <input
            v-model.number="amount"
            id="amount"
            type="number"
            :min="min"
            :step="calculatedStep"
            :class="inputClass"
            class="w-100"
        >
    </div>
</template>

<script>

export default {
    name: "NumericInput",

    props: {
        value: {
            type: Number,
            required: true,
        },
        precision: {
            type: Number,
            required: true,
        },
        min: {
            type: Number,
            required: false,
            default: 0,
        },
        max: {
            type: Number,
            required: false,
            default: null,
        },
        inputClass: {
            type: String,
            required: false,
            default: '',
        }
    },

    computed: {
        amount: {
            get: function() {
                return this.value.toFixed(this.precision);
            },
            set: function(newValue) {
                if (newValue < this.min) {
                    newValue = this.min;
                }

                if (this.max !== null && newValue > this.max) {
                    newValue = this.max;
                }

                this.$emit('input', newValue);
            }
        },

        calculatedStep() {
            return (1 / Math.pow(10, this.precision)).toFixed(this.precision);
        },
    },
}
</script>

<style scoped>
input[type=number]::-webkit-inner-spin-button, ::-webkit-outer-spin-button {
    opacity: 1;
}
</style>
