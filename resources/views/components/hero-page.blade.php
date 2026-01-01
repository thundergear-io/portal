<div class="grow flex flex-col lg:flex-row relative">
    <button class="btn btn-circle btn-ghost absolute top-4 right-4 z-50" @click="darkMode = !darkMode">
        <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
        <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
    </button>

        <!-- Left side -->
        <div class="relative w-full lg:w-1/2 lg:fixed lg:inset-0 lg:overflow-y-auto bg-slate-900 lg:rounded-r-3xl">

            <!-- Background Illustration -->
            <div class="absolute top-0 -translate-y-64 left-1/2 -translate-x-1/2 blur-3xl pointer-events-none" aria-hidden="true">
                <div class="w-96 h-96 bg-blue-500 rounded-full opacity-20"></div>
            </div>

            <div class="min-h-full w-full max-w-xl mx-auto flex flex-col justify-start px-4 sm:px-6 pt-36 pb-20 lg:py-20">
                <div class="grow flex flex-col justify-center">
        
                    <div class="space-y-3">
                        <h2 class="text-xl font-bold text-blue-500">Quote for</h2>
                        <h1 class="text-2xl font-bold text-white">The Company Corp.</h1>
                        <time class="block text-xl text-slate-400">20 April, 2024</time>
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
                        <h3 class="text-lg font-bold mb-2">Brief</h3>
                        <div class="text-slate-500 dark:text-slate-400 space-y-4">
                            The client is looking to review and revamp the information architecture, user experience and user interface design of <strong class="text-slate-900 dark:text-slate-200 font-medium">The Company Corp.</strong>, a web application that connects landlords and tenants across Europe and America.
                        </div>
                    </section>
                    
                    <section class="py-8">
                        <h3 class="text-lg font-bold mb-5">Details</h3>
                        <ul class="grid gap-4 sm:grid-cols-3 text-sm">
                            <div class="card bg-base-100 shadow-sm border border-base-200">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-sm text-slate-500 font-medium">Project Length</h4>
                                    <div class="text-slate-700 dark:text-slate-300">4-8 Weeks</div>
                                </div>
                            </div>
                            <div class="card bg-base-100 shadow-sm border border-base-200">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-sm text-slate-500 font-medium">Start Date</h4>
                                    <time class="text-slate-700 dark:text-slate-300">27 Jun, 2024</time>
                                </div>
                            </div>
                            <div class="card bg-base-100 shadow-sm border border-base-200">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-sm text-slate-500 font-medium">End Date</h4>
                                    <time class="text-slate-700 dark:text-slate-300">27 Aug, 2024</time>
                                </div>
                            </div>
                        </ul>
                    </section>
                    
                    <section class="py-8">
                        <h3 class="text-lg font-bold mb-5">Costs Breakdown</h3>
                        <div class="overflow-x-auto">
                            <table class="table w-full text-sm">
                                <thead class="sr-only">
                                    <tr>
                                        <th>Description</th>
                                        <th scope="col">Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                        <td class="px-4 py-5">
                                            <div class="font-semibold mb-1">Competitive Analysis</div>
                                            <p class="text-slate-500 dark:text-slate-400">The client is looking to review the information.</p>
                                        </td>
                                        <td class="px-4 py-5 text-right font-semibold">$7,800</td>
                                    </tr>
                                    
                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                        <td class="px-4 py-5">
                                            <div class="font-semibold mb-1">UX Research Reports</div>
                                            <p class="text-slate-500 dark:text-slate-400">The client is looking to review the information.</p>
                                        </td>
                                        <td class="px-4 py-5 text-right font-semibold">$2,560</td>
                                    </tr>
                                    
                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                        <td class="px-4 py-5">
                                            <div class="font-semibold mb-1">Sitemap and Information Architecture</div>
                                            <p class="text-slate-500 dark:text-slate-400">The client is looking to review the information.</p>
                                        </td>
                                        <td class="px-4 py-5 text-right font-semibold">$1,420</td>
                                    </tr>
                                    
                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                        <td class="px-4 py-5">
                                            <div class="font-semibold mb-1">UX Wireframes and User Flows</div>
                                            <p class="text-slate-500 dark:text-slate-400">The client is looking to review the information.</p>
                                        </td>
                                        <td class="px-4 py-5 text-right font-semibold">$3,978</td>
                                    </tr>
                                    
                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                        <td class="px-4 py-5">
                                            <div class="font-semibold mb-1">Visual Design</div>
                                            <p class="text-slate-500 dark:text-slate-400">The client is looking to review the information.</p>
                                        </td>
                                        <td class="px-4 py-5 text-right font-semibold">$4,476</td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="px-4 py-5">
                                            <div class="font-semibold mb-1">Interactive Prototypes + Assets Exports</div>
                                            <p class="text-slate-500 dark:text-slate-400">The client is looking to review the information.</p>
                                        </td>
                                        <td class="px-4 py-5 text-right font-semibold">$4,326</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="border-t border-slate-200 dark:border-slate-700">
                                        <th scope="row" class="px-4 py-5 text-left font-normal">
                                            <p class="text-slate-500 italic">Total in USD dollar</p>
                                        </th>
                                        <td class="px-4 py-5 text-right font-semibold text-emerald-500">$24,560</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </section>
                    
                    <section class="py-8">
                        <h3 class="text-lg font-bold mb-5">Project Terms</h3>
                        <div class="join join-vertical w-full">
                            <details class="collapse collapse-arrow join-item border border-base-300" open>
                                <summary class="collapse-title text-lg font-medium">
                                    Payment schedule and options
                                </summary>
                                <div class="collapse-content"> 
                                    <p class="text-slate-500 dark:text-slate-400">
                                        Defining the project scope is a collaborative effort with my client. Together, we establish key features, functionalities, and any constraints that will shape the design process. This clarity ensures that we are aligned and working towards the same goals.
                                    </p>
                                </div>
                            </details>
                            <details class="collapse collapse-arrow join-item border border-base-300">
                                <summary class="collapse-title text-lg font-medium">
                                    Deadlines and timeline
                                </summary>
                                <div class="collapse-content"> 
                                    <p class="text-slate-500 dark:text-slate-400">
                                        Defining the project scope is a collaborative effort with my client. Together, we establish key features, functionalities, and any constraints that will shape the design process. This clarity ensures that we are aligned and working towards the same goals.
                                    </p>
                                </div>
                            </details>
                        </div>
                    </section>
                </article>
                
            </div>
            
            <!-- Call to action -->
            <div class="fixed bottom-0 z-30 w-full lg:w-1/2 bg-white/80 dark:bg-slate-900/80 backdrop-blur">
                <div class="w-full max-w-xl mx-auto px-4 sm:px-6">
                    <div class="flex py-4 md:py-6 gap-4">
                        <a href="#" class="btn btn-ghost flex-1">Contact Me</a>
                        <a href="#" class="btn btn-primary flex-1 bg-blue-600 hover:bg-blue-700 text-white border-none">Pay - $24,560</a>
                    </div>
                </div>
            </div>
        </main>

</div>

