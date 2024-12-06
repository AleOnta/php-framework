<!-- START OF HOME COMPONENT -->
<div class="contanier w-full h-screen flex flex-col items-center justify-center">
    {{component:navbar}}
    <form action="/message/create-message" method="POST" class="w-2/6 text-center py-6 px-6 rounded-lg flex flex-col justify-between">

        {{component:inputs.checkboxes}}

        <div class="flex flex-row items-center justify-between mb-8">

            {{component:inputs.datepicker}}

            {{component:inputs.timepicker}}

        </div>
        <div class="py-3 px-4 rounded-lg bg-neutral-300 text-start shadow-lg">
            <label class="block text-start text-sm text-gray-700 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2" for="message">Message:</label>
            <textarea
                id="message"
                name="message"
                placeholder="Write your message here ..."
                class="w-full h-60 p-3 rounded-md"></textarea>
        </div>
        <button
            class="w-full bg-teal-700 py-3 mt-6 flex items-center justify-center rounded-xl cursor-pointer relative overflow-hidden transition-all duration-500 ease-in-out shadow-md hover:scale-100 hover:shadow-lg before:absolute before:top-0 before:-left-full before:w-full before:h-full before:bg-gradient-to-r before:bg-teal-500 before:border-t-teal-700 before:transition-all before:duration-500 before:ease-in-out before:z-[-1] before:rounded-xl hover:before:left-0 text-[#fff]">
            Send Message
        </button>
    </form>

</div>
<!-- END OF HOME COMPONENT -->