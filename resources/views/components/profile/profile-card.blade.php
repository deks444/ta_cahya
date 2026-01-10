<div x-data="{
    saveProfile() {
        this.$refs.profileForm.submit();
    },
    changePassword() {
        this.$refs.passwordForm.submit();
    }
}">
    <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-col items-center gap-6 xl:flex-row xl:flex-shrink-0">
                <div class="h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800">
                    @if (Auth::user()->avatar)
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="user" class="h-full w-full object-cover" />
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                            alt="user" class="h-full w-full object-cover" />
                    @endif
                </div>
                <div>
                    <h4 class="mb-1 text-center text-base font-semibold text-gray-800 xl:text-left dark:text-white/90">
                        {{ Auth::user()->name }}
                    </h4>
                    <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            @if(Auth::user()->role === 'admin')
                                Administrator
                            @elseif(Auth::user()->role === 'pelatih')
                                Pelatih
                            @else
                                Atlit
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 justify-center xl:justify-end w-full xl:w-auto">
                <button @click="$dispatch('open-change-password-modal')"
                    class="flex w-full items-center justify-center gap-2 rounded-full bg-gray-900 px-4 lg:px-12 py-3 lg:py-1.5 text-sm font-medium text-white shadow-theme-xs hover:bg-gray-800 lg:inline-flex lg:w-auto dark:bg-white/10 dark:text-white dark:hover:bg-white/20">
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.5 6V5.25C13.5 2.76472 11.4853 0.75 9 0.75C6.51472 0.75 4.5 2.76472 4.5 5.25V6C3.25736 6 2.25 7.00736 2.25 8.25V13.5C2.25 14.7426 3.25736 15.75 4.5 15.75H13.5C14.7426 15.75 15.75 14.7426 15.75 13.5V8.25C15.75 7.00736 14.7426 6 13.5 6ZM6 5.25C6 3.59315 7.34315 2.25 9 2.25C10.6569 2.25 12 3.59315 12 5.25V6H6V5.25Z"
                            fill="" />
                    </svg>
                    Change Password
                </button>

                <button @click="$dispatch('open-profile-info-modal')"
                    class="shadow-theme-xs flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 lg:px-12 py-3 lg:py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 lg:inline-flex lg:w-auto dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"
                            fill="" />
                    </svg>
                    Edit
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Info Modal -->
    <x-ui.modal x-data="{ open: false }" @open-profile-info-modal.window="open = true" :isOpen="false">
        <div
            class="no-scrollbar relative w-full max-w-[700px] mx-auto overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
            <div class="px-2 pr-14">
                <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                    Edit Personal Information
                </h4>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                    Update your details to keep your profile up-to-date.
                </p>
            </div>
            <form x-ref="profileForm" method="POST" action="{{ route('admin.profile.update') }}" class="flex flex-col"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="custom-scrollbar h-[458px] overflow-y-auto p-2">
                    <div class="mt-7">
                        <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90 lg:mb-6">
                            Personal Information
                        </h5>

                        <div class="mb-5">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Profile Photo
                            </label>
                            <input type="file" name="avatar" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-800 dark:file:text-gray-200" />
                        </div>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                            <div class="col-span-2 lg:col-span-1">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    First Name
                                </label>
                                <input type="text" name="first_name" value="{{ explode(' ', Auth::user()->name)[0] }}"
                                    class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            </div>

                            <div class="col-span-2 lg:col-span-1">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Last Name
                                </label>
                                <input type="text" name="last_name"
                                    value="{{ count(explode(' ', Auth::user()->name)) > 1 ? implode(' ', array_slice(explode(' ', Auth::user()->name), 1)) : '' }}"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            </div>

                            <div class="col-span-2 lg:col-span-1">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Username
                                </label>
                                <input type="text" name="username" value="{{ Auth::user()->username }}"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            </div>

                            <div class="col-span-2 lg:col-span-1">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Phone (No HP)
                                </label>
                                <input type="text" name="no_hp" value="{{ Auth::user()->no_hp }}"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
                    <button @click="open = false" type="button"
                        class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                        Close
                    </button>
                    <button @click="saveProfile" type="button"
                        class="flex w-full justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 sm:w-auto">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    <!-- Change Password Modal -->
    <x-ui.modal x-data="{ open: false }" @open-change-password-modal.window="open = true" :isOpen="false">
        <div
            class="no-scrollbar relative w-full max-w-[700px] mx-auto overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
            <div class="px-2 pr-14">
                <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                    Change Password
                </h4>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                    Update your password to keep your account secure.
                </p>
            </div>
            <form x-ref="passwordForm" method="POST" action="{{ route('admin.profile.password.update') }}"
                class="flex flex-col">
                @csrf
                @method('PUT')
                <div class="custom-scrollbar overflow-y-auto p-2">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-5">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Current Password
                            </label>
                            <input type="password" name="current_password" required
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                New Password
                            </label>
                            <input type="password" name="password" required
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Confirm New Password
                            </label>
                            <input type="password" name="password_confirmation" required
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
                    <button @click="open = false" type="button"
                        class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                        Close
                    </button>
                    <button @click="changePassword" type="button"
                        class="flex w-full justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 sm:w-auto">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>
</div>