<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import AuthLayout from '@/layouts/AuthLayout.vue';

const props = defineProps({
    countries: Object,
    cities: Object,
})

const currentStep = ref(1)

const form = useForm({ 
    step1: {
       from_country: '',
       from_city: '',
    },
    step2: {
       to_country: '',
       to_city: '',
    },
    step3: {
       adults: 0,
       children: 0,
    },
}) 

const submit = () => {
    form.clearErrors()
    if(currentStep.value < 3) {
        currentStep.value = currentStep.value + 1;
    } else {
        form.post(route('multi-step.store'), {
            onError: (errors) => {
                let firstErrorKey = Object.keys(errors)[0];
                let stepNumberMatch = firstErrorKey.match(/step(\d+)/);

                currentStep.value = Number(stepNumberMatch[1])
            }
        })
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex"> 
                            <button type="button" v-on:click="currentStep = 1" :class="[currentStep === 1 ? 'rounded-sm border border-b-0' : 'border-b']" class="cursor-pointer border-indigo-500 bg-gray-100 p-2 text-gray-700 outline-none focus:outline-none">From</button>
                            <button type="button" v-on:click="currentStep = 2" :class="[currentStep === 2 ? 'rounded-sm border border-b-0' : 'border-b']" class="cursor-pointer border-indigo-500 bg-gray-100 p-2 text-gray-700 outline-none focus:outline-none" :disabled="currentStep < 2">To</button>
                            <button type="button" v-on:click="currentStep = 3" :class="[currentStep === 3 ? 'rounded-sm border border-b-0' : 'border-b']" class="cursor-pointer border-indigo-500 bg-gray-100 p-2 text-gray-700 outline-none focus:outline-none" :disabled="currentStep < 3">Passengers</button>
                            <div class="flex-grow border-b border-indigo-500"></div>
                        </div>
 
                        <form @submit.prevent="submit">
                           <div v-if="currentStep === 1">
                               <!-- Step 1 -->
                               <div class="mt-4"> 
                                   <label for="from-country" class="block text-sm font-medium text-gray-700">From Country</label>
                                   <select id="from-country" v-model="form.step1.from_country" class="mt-2 w-52 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                       <option value="">--</option>
                                       <option v-for="country in props.countries" :value="country.id" :key="country.id">
                                           {{ country.name }}
                                       </option>
                                   </select>
                                   <div class="mt-2 text-sm text-red-600" v-show="form.errors['step1.from_country']">
                                    {{ form.errors['step1.from_country'] }}
                                   </div>
                               </div>
 
                               <div class="mt-4">
                                   <label for="from-city" class="block text-sm font-medium text-gray-700">From City</label>
                                   <select id="from-city" v-model="form.step1.from_city" class="mt-2 w-52 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                       <option value="">--</option>
                                       <option v-for="city in props.cities[form.step1.from_country]" :value="city.id" :key="city.id">
                                           {{ city.name }}
                                       </option>
                                   </select>
                                   <div class="mt-2 text-sm text-red-600" v-show="form.errors['step1.from_city']"> 
                                       {{ form.errors['step1.from_city'] }}
                                   </div>
                               </div> 
                           </div>
 
                           <div v-if="currentStep === 2">
                               <!-- Step 2 -->
                               <div class="mt-4"> 
                                   <label for="to-country" class="block text-sm font-medium text-gray-700">To Country</label>
                                   <select id="to-country" v-model="form.step2.to_country" class="mt-2 w-52 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                       <option value="">--</option>
                                       <option v-for="country in props.countries" :value="country.id" :key="country.id">
                                           {{ country.name }}
                                       </option>
                                   </select>
                                   <div class="mt-2 text-sm text-red-600" v-show="form.errors['step2.to_country']"> 
                                       {{ form.errors['step2.to_country'] }}
                                   </div>
                               </div>
 
                               <div class="mt-4">
                                   <label for="to-city" class="block text-sm font-medium text-gray-700">To City</label>
                                   <select id="to-city" v-model="form.step2.to_city" class="mt-2 w-52 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                       <option value="">--</option>
                                       <option v-for="city in props.cities[form.step2.to_country]" :value="city.id" :key="city.id">
                                           {{ city.name }}
                                       </option>
                                   </select>
                                   <div class="mt-2 text-sm text-red-600" v-show="form.errors['step2.to_city']"> 
                                       {{ form.errors['step2.to_city'] }}
                                   </div>
                               </div> 
                           </div>
 
                           <div v-if="currentStep === 3">
                               <!-- Step 3 -->
                               <div class="mt-4"> 
                                   <label for="adults-number" class="block text-sm font-medium text-gray-700">Adults</label>
                                   <input v-model="form.step3.adults" id="adults-number" type="number" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required />
                                   <div class="mt-2 text-sm text-red-600" v-show="form.errors['step3.adults']"> 
                                       {{ form.errors['step3.adults'] }}
                                   </div>
                               </div>
 
                               <div class="mt-4">
                                   <label for="children-number" class="block text-sm font-medium text-gray-700">Children</label>
                                   <input v-model="form.step3.children" id="children-number" type="number" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required />
                                   <div class="mt-2 text-sm text-red-600" v-show="form.errors['step3.children']"> 
                                       {{ form.errors['step3.children'] }}
                                   </div>
                               </div> 
                           </div>
 
                            <button class="mt-4 inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900">
                                {{ currentStep < 3 ? 'Next' : 'Submit' }}
                            </button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>