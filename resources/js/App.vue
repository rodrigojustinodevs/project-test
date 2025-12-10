<template>  
    <div class="container mx-auto p-8 max-w-4xl">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Formatador de CPFs</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="cpfs-input" class="block text-sm font-medium text-gray-700 mb-2">
                    Digite os CPFs separados por ponto e vírgula (;)
                </label>
                <textarea
                    id="cpfs-input"
                    v-model="cpfsInput"
                    rows="4"
                    placeholder="Ex: 12345678901; 98765432100; 11122233344"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
            </div>
            
            <button
                @click="processarCpfs"
                :disabled="loading || !cpfsInput.trim()"
                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors"
            >
                {{ loading ? 'Processando...' : 'Processar CPFs' }}
            </button>
            
            <div v-if="erro" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                <p class="text-sm text-red-600">{{ erro }}</p>
            </div>
            
            <div v-if="cpfsFormatados.length > 0" class="mt-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">CPFs Formatados:</h2>
                <ul class="space-y-2">
                    <li
                        v-for="(cpf, index) in cpfsFormatados"
                        :key="index"
                        class="p-3 bg-gray-50 rounded-md border border-gray-200 font-mono text-gray-800"
                    >
                        {{ cpf }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const cpfsInput = ref('');
const cpfsFormatados = ref([]);
const loading = ref(false);
const erro = ref('');

const processarCpfs = async () => {
    if (!cpfsInput.value.trim()) {
        erro.value = 'Por favor, digite pelo menos um CPF.';
        return;
    }
    
    loading.value = true;
    erro.value = '';
    cpfsFormatados.value = [];
    
    try {
        const response = await axios.post('/api/processar-cpfs', {
            cpfs: cpfsInput.value
        });
        
        if (response.data.success) {
            cpfsFormatados.value = response.data.data;
        } else {
            erro.value = response.data.message || 'Erro ao processar CPFs.';
        }
    } catch (error) {
        if (error.response?.data?.message) {
            erro.value = error.response.data.message;
        } else {
            erro.value = 'Erro ao conectar com a API. Tente novamente.';
        }
    } finally {
        loading.value = false;
    }
};
</script>