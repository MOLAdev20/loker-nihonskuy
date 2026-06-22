<footer id="footer" class="border-t border-slate-200 bg-white">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <div class="grid gap-8 md:grid-cols-4">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2">
                    <div class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm" aria-hidden="true">
                        <img src="/logo.png" width="10px" />
                    </div>
                    <div>
                        <div class="text-sm font-semibold">NihonSkuy</div>
                        <div class="text-xs text-slate-500">Temukan karir impianmu di Jepang</div>
                    </div>
                </div>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-slate-600">457-0025 Hakuun-cho, Minami-ku, </br> Nagoya-shi, Aichi-ken, Japan.</p>

                <!-- <form class="mt-5 flex max-w-md gap-2" onsubmit="event.preventDefault();">
                    <input
                        type="email"
                        required
                        placeholder="Email untuk job alerts"
                        class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-slate-200" />
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                        Subscribe
                    </button>
                </form>

                <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-500">
                    <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1">No spam</span>
                    <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1">Unsubscribe anytime</span>
                </div> -->
            </div>

            <div>
                <div class="text-sm font-semibold">Menu</div>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a class="hover:text-slate-900" href="#jobs">Top Jobs</a></li>
                    <li><a class="hover:text-slate-900" href="#about">About Us</a></li>
                    <li><a class="hover:text-slate-900" href="{{ route('jp.company') }}">Perusahaan</a></li>
                    <li><a class="hover:text-slate-900" href="#testimonials">Testimoni</a></li>
                    <li><a class="hover:text-slate-900" href="#">FAQ</a></li>
                </ul>
            </div>

            <div>
                <div class="text-sm font-semibold">Kontak & Sosial Media</div>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a class="hover:text-slate-900" href="mailto:nihonskuy@gmail.com">nihonskuy@gmail.com</a></li>
                    <li><a class="hover:text-slate-900" href="https://wa.me/+6289514161277">+62 895-1416-1277</a></li>
                    <li><a class="hover:text-slate-900" href="https://instagram.com/nihonskuy">Instagram Nihonskuy</a></li>
                    <!-- <li class="pt-2">
                        <div class="text-xs text-slate-500">Social</div>
                        <div class="mt-2 flex gap-2">
                            <a
                                href="#"
                                class="rounded-xl border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50"
                                aria-label="Twitter"
                                title="Twitter">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M20 7.5c-.6.3-1.3.5-2 .6.7-.4 1.2-1.1 1.4-1.9-.7.4-1.4.7-2.2.8A3.3 3.3 0 0 0 11.6 9c0 .3 0 .6.1.8-2.8-.1-5.2-1.5-6.8-3.6-.3.6-.5 1.2-.5 1.9 0 1.1.6 2.2 1.6 2.8-.5 0-1-.2-1.5-.4v.1c0 1.6 1.1 2.9 2.6 3.2-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.4 1.8 2.4 3.3 2.4A6.7 6.7 0 0 1 4 18.5 9.4 9.4 0 0 0 9.1 20c6 0 9.3-5 9.3-9.3v-.4c.6-.5 1.2-1.1 1.6-1.8Z"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>

                            <a
                                href="#"
                                class="rounded-xl border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50"
                                aria-label="LinkedIn"
                                title="LinkedIn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M6.5 10.5V18M6.5 6.8v.1M10.5 18v-4.2c0-1.2 1-2.2 2.2-2.2 1.2 0 2.2 1 2.2 2.2V18M10.5 10.5V18"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round" />
                                </svg>
                            </a>

                            <a
                                href="#"
                                class="rounded-xl border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50"
                                aria-label="GitHub"
                                title="GitHub">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M9 19c-4 1.5-4-2-5-2m10 4v-3.2c0-.9.3-1.4.7-1.8-2.2-.2-4.5-1.1-4.5-5 0-1.1.4-2 1-2.7-.1-.3-.4-1.3.1-2.7 0 0 .8-.3 2.7 1a9 9 0 0 1 4.9 0c1.9-1.3 2.7-1 2.7-1 .5 1.4.2 2.4.1 2.7.6.7 1 1.6 1 2.7 0 3.9-2.3 4.8-4.5 5 .4.4.8 1.1.8 2.2V21"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </li> -->
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-2 border-t border-slate-200 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <div>© <span id="year"></span> NihonSkuy. All rights reserved.</div>
            <div class="flex gap-4">
                <a href="#" class="hover:text-slate-700">Privacy</a>
                <a href="#" class="hover:text-slate-700">Terms</a>
                <a href="#" class="hover:text-slate-700">Cookies</a>
            </div>
        </div>
    </div>
</footer>
