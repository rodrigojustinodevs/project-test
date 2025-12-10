<template> 
    <div class="cpf-input-container">
         <label v-if="label" :for="inputId" class="block text-sm font-medium text-gray-700 mb-1">
            {{ label }}
        </label>
        <input
            :id="inputId"
            ref="inputRef"
            type="text"
            :value="formattedValue"
            @input="handleInput"
            @blur="handleBlur"
            :placeholder="placeholder"
            :class="inputClasses"
        />
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<script setup>



</script>