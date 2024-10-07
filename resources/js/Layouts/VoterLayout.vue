<template>
    <div class=" min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 relative">
        <div class="text-white mb-10">
            <h1 class="text-xl"> Welcome, {{ voter.name }} </h1>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white  shadow-md overflow-hidden sm:rounded-lg text-dark flex flex-col  justify-center gap-8"
        >
            <slot />
        </div>
        <div class="relative">

        </div>
        <small class="absolute bottom-4 text-gray-500 dark:text-gray-400">
            <a href="https://tigernethost.com/">Powered by: Tigernethost, OPC</a>
        </small>
    </div>
</template>

<script>
export default {
    props: { 
        voter: Object
    },
}

</script>