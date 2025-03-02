<script setup>
import {computed} from 'vue';
import { useRoute } from 'vue-router';
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {Bars3Icon, XMarkIcon} from '@heroicons/vue/24/outline'
import {useAuthStore} from "@/store/auth.js";

const route = useRoute();
const authStore = useAuthStore();

const userNavigation = [
  {name: 'Sign out', href: '/logout'},
]

const navRoutes = {
  teacher: [
    {name: 'Dashboard', href: {name: 'TeacherDashboard'}},
    {name: 'Worksheets', href: {name: 'Worksheets'}},
    {name: 'Students', href: {name: 'Students'}}
  ],
  student: [
    {name: 'Dashboard', href: {name: 'StudentDashboard'}},
    {name: 'Worksheets', href: {name: 'StudentAssignments'}},
  ],
}

const navigation = navRoutes[authStore.user.role];

const navItems = computed(() =>
  navigation.map(item => {
    // Check if the current route is the same as the item or if any of the parent routes match.
    const isActive =
      route.name === item.href.name ||
      route.matched.some(record => record.name === item.href.name);
    return { ...item, current: isActive };
  })
);
</script>

<template>
  <Disclosure as="nav" class="bg-white shadow-xs" v-slot="{ open }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 justify-between">
        <div class="flex">
          <div class="flex shrink-0 items-center">
            <img class="block h-8 w-auto lg:hidden border border-sky-300 rounded" src="/src/assets/edumaster-1.svg"
                 alt="EduMaster"/>
            <img class="hidden h-8 w-auto lg:block" src="/src/assets/edumaster-1.svg" alt="EduMaster"/>
          </div>
          <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
            <RouterLink v-for="item in navItems" :key="item.name" :to="item.href"
                        :class="[item.current ? 'border-sky-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium']"
                        :aria-current="item.current ? 'page' : undefined">{{ item.name }}
            </RouterLink>
          </div>
        </div>
        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <!-- Profile dropdown -->
          <Menu as="div" class="relative ml-3">
            <div>
              <MenuButton
                class="relative flex rounded-full bg-white text-sm focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:outline-hidden">
                <span class="absolute -inset-1.5"/>
                <span class="sr-only">Open user menu</span>
                <span class="bg-gray-200 border border-sky-300 size-8 rounded-full flex justify-center items-center">
                    {{ authStore.user?.name[0] }}
                  </span>
              </MenuButton>
            </div>
            <transition enter-active-class="transition ease-out duration-200"
                        enter-from-class="transform opacity-0 scale-95"
                        enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95">
              <MenuItems
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden">
                <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                  <RouterLink :to="item.href"
                              :class="[active ? 'bg-gray-100 outline-hidden' : '', 'block px-4 py-2 text-sm text-gray-700']">
                    {{ item.name }}
                  </RouterLink>
                </MenuItem>
              </MenuItems>
            </transition>
          </Menu>
        </div>
        <div class="-mr-2 flex items-center sm:hidden">
          <!-- Mobile menu button -->
          <DisclosureButton
            class="relative inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:outline-hidden">
            <span class="absolute -inset-0.5"/>
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true"/>
            <XMarkIcon v-else class="block size-6" aria-hidden="true"/>
          </DisclosureButton>
        </div>
      </div>
    </div>

    <DisclosurePanel class="sm:hidden">
      <div class="space-y-1 pt-2 pb-3">
        <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href"
                          :class="[item.current ? 'border-sky-500 bg-sky-50 text-sky-700' : 'border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800', 'block border-l-4 py-2 pr-4 pl-3 text-base font-medium']"
                          :aria-current="item.current ? 'page' : undefined">{{ item.name }}
        </DisclosureButton>
      </div>
      <div class="border-t border-gray-200 pt-4 pb-3">
        <div class="flex items-center px-4">
          <div class="shrink-0">
            <span class="bg-gray-200 size-10 rounded-full flex justify-center items-center">G</span>
          </div>
          <div class="ml-3">
            <div class="text-base font-medium text-gray-800">{{ authStore.user.name }}</div>
            <div class="text-sm font-medium text-gray-500">{{ authStore.user.email }}</div>
          </div>
        </div>
        <div class="mt-3 space-y-1">
          <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">
            {{ item.name }}
          </DisclosureButton>
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>