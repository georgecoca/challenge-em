<script setup>
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue';
import {EllipsisVerticalIcon} from '@heroicons/vue/20/solid';

defineProps({
  menuItems: Array,
  resource: Object,
})
</script>

<template>
  <Menu as="div" class="relative flex-none">
    <MenuButton class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900">
      <span class="sr-only">Open options</span>
      <EllipsisVerticalIcon class="size-5" aria-hidden="true"/>
    </MenuButton>
    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
      <MenuItems
        class="absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white py-2 ring-1 shadow-lg ring-gray-900/5 focus:outline-hidden">
        <MenuItem v-for="item in menuItems" v-slot="{ active }">
          <a href="javascript:" @click="item.handle(resource)" :class="[active ? 'bg-gray-50 outline-hidden' : '', 'block px-3 py-1 text-sm/6 text-gray-900']">
            {{ item.name }}<span class="sr-only">, {{ item.name }}</span>
          </a>
        </MenuItem>
      </MenuItems>
    </transition>
  </Menu>
</template>