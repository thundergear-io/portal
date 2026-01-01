<div class="flex flex-col min-h-screen overflow-hidden">

    <!-- Site header -->
    <header class="absolute w-full z-30">
        <div class="max-w-xl lg:max-w-[calc(50%+(var(--container-xl)))] mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16 md:h-20">
    
                <!-- Site branding -->
                <div class="shrink-0 mr-4 lg:fixed">
                    <!-- Logo -->
                    <a class="flex items-center space-x-4" href="{{ url('/') }}" aria-label="Cruip">
                        <img class="rounded-full" src="/themes/default/assets/images/logo.jpg" width="32" height="32" alt="Logo">
                        <span class="font-caveat text-xl text-slate-200">Mary Rutt</span>
                    </a>
                </div>
    
                <!-- Right side -->
                <div class="flex grow justify-end">
        
                    <!-- Light switch -->
                    <div class="flex flex-col justify-center">
                        <input type="checkbox" name="light-switch" id="light-switch" class="light-switch peer sr-only" />
                        <label class="relative cursor-pointer h-8 w-8 inline-flex items-center justify-center rounded-full bg-slate-900 border border-slate-800 hover:border-slate-700 lg:bg-white lg:border-slate-200 lg:hover:border-slate-300 dark:bg-slate-900 dark:border-slate-800 dark:hover:border-slate-700 peer-focus-visible:outline peer-focus-visible:outline-blue-500 shadow-sm shadow-black/5 transition-colors" for="light-switch">
                            <svg class="dark:hidden" width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                <path class="fill-slate-400 lg:fill-slate-300" d="M7 0h2v2H7zM12.88 1.637l1.414 1.415-1.415 1.413-1.413-1.414zM14 7h2v2h-2zM12.95 14.433l-1.414-1.413 1.413-1.415 1.415 1.414zM7 14h2v2H7zM2.98 14.364l-1.413-1.415 1.414-1.414 1.414 1.415zM0 7h2v2H0zM3.05 1.706 4.463 3.12 3.05 4.535 1.636 3.12z" />
                                <path class="fill-slate-500 lg:fill-slate-400" d="M8 4C5.8 4 4 5.8 4 8s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4Z" />
                            </svg>
                            <svg class="hidden dark:block" width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                <path class="fill-slate-500" d="M6.2 1C3.2 1.8 1 4.6 1 7.9 1 11.8 4.2 15 8.1 15c3.3 0 6-2.2 6.9-5.2C9.7 11.2 4.8 6.3 6.2 1Z" />
                                <path class="fill-slate-400" d="M12.5 5a.625.625 0 0 1-.625-.625 1.252 1.252 0 0 0-1.25-1.25.625.625 0 1 1 0-1.25 1.252 1.252 0 0 0 1.25-1.25.625.625 0 1 1 1.25 0c.001.69.56 1.249 1.25 1.25a.625.625 0 1 1 0 1.25c-.69.001-1.249.56-1.25 1.25A.625.625 0 0 1 12.5 5Z" />
                            </svg>
                            <span class="sr-only">Switch to light / dark version</span>
                        </label>
                    </div>
    
                </div>
    
            </div>
        </div>
    </header>

    <div class="grow flex flex-col lg:flex-row">

        <!-- Left side -->
        <div class="relative w-full lg:w-1/2 lg:fixed lg:inset-0 lg:overflow-y-auto no-scrollbar bg-slate-900">

            <!-- Background Illustration -->
            <div class="absolute top-0 -translate-y-64 left-1/2 -translate-x-1/2 blur-3xl pointer-events-none" aria-hidden="true">
                <img class="max-w-none" src="/themes/default/assets/images/bg-illustration.svg" width="785" height="685" alt="Bg illustration">
            </div>

            <div class="min-h-full w-full max-w-xl mx-auto flex flex-col justify-start px-4 sm:px-6 pt-36 pb-20 lg:py-20">
                <div class="grow flex flex-col justify-center">
        
                    <div class="space-y-3">
                        <div class="font-caveat text-3xl text-blue-500">Quote for</div>
                        <h1 class="h1 font-orbiter font-bold text-white">The Markyk Corp.</h1>
                        <time class="block font-caveat text-xl text-slate-400 before:content-['—_']">20 April, 2024</time>
                    </div>
        
                </div>
            </div>
        </div>

        <!-- Right side -->
        <main class="max-lg:grow flex flex-col w-full lg:w-1/2 lg:ml-auto">
            <!-- Page content -->
            <div class="grow w-full max-w-xl mx-auto px-4 sm:px-6 py-12 lg:pt-24 lg:pb-20">

                <article class="divide-y divide-slate-100 dark:divide-slate-800 -mt-8 mb-4">
                    <section class="py-8">
                        <h2 class="text-lg font-semibold mb-2">Brief</h2>
                        <div class="text-slate-500 dark:text-slate-400 space-y-4">
                            The client is looking to review and revamp the information architecture, user experience and user interface design of <strong class="text-slate-900 dark:text-slate-200 font-medium">The Markyk Corp.</strong>, a web application that connects landlords and tenants across Europe and America.
                        </div>
                    </section>
                    <section class="py-8">
                        <h2 class="text-lg font-semibold mb-5">Details</h2>
                        <ul class="grid gap-4 min-[480px]:grid-cols-3 text-sm">
                            <li class="px-5 py-4 rounded-3xl bg-linear-to-tr from-slate-950 to-slate-800 dark:from-slate-800/80 dark:to-slate-900">
                                <div class="text-slate-200 font-medium">Project Length</div>
                                <div class="text-slate-400">4-8 Weeks</div>
                            </li>
                            <li class="px-5 py-4 rounded-3xl bg-linear-to-tr from-slate-950 to-slate-800 dark:from-slate-800/80 dark:to-slate-900">
                                <div class="text-slate-200 font-medium">Start Date</div>
                                <time class="text-slate-400">27 Jun, 2024</time>
                            </li>
                            <li class="px-5 py-4 rounded-3xl bg-linear-to-tr from-slate-950 to-slate-800 dark:from-slate-800/80 dark:to-slate-900">
                                <div class="text-slate-200 font-medium">End Date</div>
                                <time class="text-slate-400">27 Aug, 2024</time>
                            </li>
                        </ul>
                    </section>
                    <section class="py-8">
                        <h2 class="text-lg font-semibold mb-5">Costs Breakdown</h2>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm">
                                <thead class="sr-only">
                                    <tr>
                                        <th>Description</th>
                                        <th scope="col">Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- rows omitted for brevity in component -->
                                    <tr class="group odd:bg-linear-to-tr from-slate-100 to-slate-50 dark:from-slate-800/80 dark:to-slate-900">
                                        <th scope="row" class="relative text-left font-normal px-4 py-5 first:rounded-l-lg last:rounded-r-lg after:w-px after:h-8 after:bg-slate-200 dark:after:bg-slate-800 after:absolute after:right-0 after:top-1/2 after:-translate-y-1/2 group-hover:after:opacity-0 after:transition-opacity">
                                            <div class="font-semibold mb-0.5">
                                                <a class="before:absolute before:inset-0 before:z-20 before:rounded-3xl" href="#">
                                                    Competitive Analysis
                                                </a>
                                            </div>
                                            <p class="text-slate-500 dark:text-slate-400">The client is looking to review the information.</p>
                                        </th>
                                        <td class="relative font-semibold text-right px-4 py-5 first:rounded-l-lg last:rounded-r-lg w-[1%]">
                                            <a class="group-hover:opacity-0 transition-opacity before:absolute before:inset-0 before:z-20 before:rounded-3xl" href="#" tabindex="-1">$7,800</a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="row" class="relative text-left font-normal px-4 py-5">
                                            <p class="text-slate-500 italic">TOT in USD dollar</p>
                                        </th>
                                        <td class="relative font-semibold text-right text-emerald-500 text-base underline px-4 py-5 w-[1%]">$24,560</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </section>
                    <section class="py-8">
                        <h2 class="text-lg font-semibold mb-5">Project Terms</h2>
                        <!-- Accordion -->
                        <div class="space-y-3">
                            <div x-data="{ expanded: false }" class="text-sm odd:bg-linear-to-tr from-slate-100 to-slate-50 dark:from-slate-800/80 dark:to-slate-900 rounded-3xl">
                                <h3>
                                    <button 
                                        id="terms-title-01"
                                        type="button"
                                        class="flex items-center justify-between w-full text-left font-medium px-5 py-3"
                                        @click="expanded = !expanded"
                                        :aria-expanded="expanded"
                                        aria-controls="terms-text-01"
                                    >
                                        <span>Payment schedule and options</span>
                                        <svg class="fill-slate-400 dark:fill-slate-500 shrink-0 ml-8" width="12" height="12" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="5" width="12" height="2" rx="1" class="transform origin-center transition duration-200 ease-out" :class="{'rotate-180!': expanded}" />
                                            <rect y="5" width="12" height="2" rx="1" class="transform origin-center rotate-90 transition duration-200 ease-out" :class="{'rotate-180!': expanded}" />
                                        </svg>
                                    </button>
                                </h3>
                                <div
                                    id="terms-text-01"
                                    role="region"
                                    aria-labelledby="terms-title-01"
                                    class="grid text-slate-500 dark:text-slate-400 overflow-hidden transition-all duration-300 ease-in-out"
                                    :class="expanded ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                                >
                                    <div class="overflow-hidden">
                                        <p class="px-5 pb-3">
                                            Defining the project scope is a collaborative effort with my client. Together, we establish key features, functionalities, and any constraints that will shape the design process. This clarity ensures that we are aligned and working towards the same goals.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </article>
                
            </div>
            <!-- Call to action -->
            <div class="fixed bottom-0 z-30 w-full lg:w-1/2 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xs">
                <div class="w-full max-w-xl mx-auto px-4 sm:px-6">
                    <div class="flex py-4 md:py-6 space-x-4">
                        <a class="btn w-full text-slate-900 dark:text-slate-200 shadow-sm shadow-black/5" href="#">Contact Me</a>
                        <a class="btn w-full text-white bg-blue-500 hover:bg-blue-600 shadow-sm shadow-black/5 animate-shine bg-[linear-gradient(100deg,var(--color-blue-500),45%,var(--color-blue-400),55%,var(--color-blue-500))] bg-[size:200%_100%] hover:bg-[image:none]" href="#">Pay - $24.560</a>
                    </div>
                </div>
            </div>
        </main>

    </div>

</div>
