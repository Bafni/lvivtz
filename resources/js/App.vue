<template>
    <div v-if="answer" class="container mx-auto max-w-md p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <span class="font-medium">Info alert!</span> {{answer.data}}.
    </div>
    <div>
        <form @submit.prevent="onSubmit"
              class="mt-6 shadow-xl container mx-auto my-auto max-w-md pt-6 bg-white rounded-md">
            <div class="m-6">
                <label for="integration" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Integration</label>
                <select v-model="integration_id"  id="integration" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    <option v-if="integration" v-for="(v ,k) of integration"
                            :key="k"
                            :value="k"
                    >{{ v }}
                    </option>

                </select>
            </div>
            <div class="m-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Name</label>
                <input type="text" id="name" v-model="name"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                       placeholder="your name" @blur="nameBlur">
                <p v-if="nameError" class="mt-2 text-sm text-red-600 dark:text-green-500"><span class="font-medium"></span>
                    {{ nameError }}!</p>
            </div>
            <div class="m-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Password</label>
                <input type="password" id="password" v-model="password"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                       placeholder="password" >

            </div>
            <div class="m-6">
                <label for="Last Name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                    Name</label>
                <input type="text" id="Last Name" v-model="lastName"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                       placeholder="your last name" @blur="lastNameBlur">
                <p v-if="lastNameError" class="mt-2 text-sm text-red-600 dark:text-green-500"><span class="font-medium"></span>
                    {{ lastNameError }}!</p>
            </div>
            <div class="m-6">
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone
                    Number</label>
                <input type="text" id="phone" v-model="phone"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                       placeholder="your phone number" @blur="phoneBlur">
                <p v-if="phoneError" class="mt-2 text-sm text-red-600 dark:text-green-500"><span class="font-medium"></span>
                    {{ phoneError }}!</p>
            </div>
            <div class="m-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" id="email" v-model="email"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                       placeholder="name@flowbite.com" @blur="eBlur">
                <p v-if="eError" class="mt-2 text-sm text-red-600 dark:text-green-500"><span class="font-medium"></span>
                    {{ eError }}!</p>
            </div>
            <div class="m-6">
                <div class="flex items-center h-5">
                    <input id="authorization" v-model="authorization" type="checkbox" value="true" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800">
                </div>
                <label for="authorization" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">With authorization</label>
            </div>

            <div class="">
                <button type="submit"
                        class="m-6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    SignUp
                </button>
            </div>

        </form>
    </div>

</template>

<script>
import axios from "axios";
import {ref, onMounted, onUpdated, watch} from "vue";
import {useField, useForm} from "vee-validate";
import * as yup from "yup";
export default {
    name: "App",
    setup() {
        const {handleSubmit, isSubmitting, submitCount} = useForm()
        const integration = ref('');
        const password = ref('')
        const answer = ref('')
        const authorization = ref(false)


        watch(answer, (newValue, oldValue) => {
            if(newValue.status === 'ok') {
                setTimeout(() => {
                    answer.value = ''
                },3000 )
            }
        })


        onMounted(async ()  => {
            const response = await axios.get('/api/integration')
            integration.value = await response.data
            console.log(integration.value)

        })
        const {value: lastName, errorMessage: lastNameError, handleBlur: lastNameBlur} = useField('lastName',
            yup
                .string()
                .trim()
                .required('Поле обов`язкове до заповнення!')
        )
        const {value: phone, errorMessage: phoneError, handleBlur: phoneBlur} = useField('phone',
            yup
                .string()
                .trim()
                .required('Поле обов`язкове до заповнення!')
        )
        const {value: name, errorMessage: nameError, handleBlur: nameBlur} = useField('name',
            yup
                .string()
                .trim()
                .required('Поле обов`язкове до заповнення!')
        )
        const {value: email, errorMessage: eError, handleBlur: eBlur} = useField('email',
            yup
                .string()
                .trim()
                .required('Поле обов`язкове до заповнення!')
                .email('Введіть вірний email')
        )

       // const {value: authorization} = useField('authorization')
       //authorization.value = false
        const {value: integration_id} = useField('integration_id')
        integration_id.value = 0


        const onSubmit = handleSubmit((values, event) => {

            values['password'] = password.value
            if(authorization.value === true) {

                console.log(values)
                axios
                    .request({
                        method: 'post',
                        baseURL: '/api/signup',
                        headers: {'Authorization': 'need '},
                        data: values,
                    })
                    .then(re => {
                        answer.value = re.data
                        console.log('auth', re.data)
                    })
            }else {
                axios
                    .request({
                        method: 'post',
                        baseURL: '/api/signup',
                        data: values,
                    })
                    .then(re => {
                        answer.value = re.data
                        console.log(re.data)
                    })

            }


            console.log('success-validate-form-value', values)

        })

        return {
            name, password,
            lastNameError,  lastNameBlur,
            phoneError, phoneBlur,
            nameError, nameBlur,
            eError, eBlur,

            integration, integration_id, authorization, answer,

            lastName, phone, email, onSubmit
        }
    }
}
</script>

<style scoped>

</style>
