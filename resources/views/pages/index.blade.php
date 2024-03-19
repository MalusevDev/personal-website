<x-layouts.website>
    <x-slot:css>
        @vite('resources/css/pages/home.css')
    </x-slot:css>

    <x-slot:meta>
        <meta name="description"
              content="I'm an experienced remote software developer deeply passionate about creating efficient and elegant solutions"/>
        <meta property="og:title" content="Dušan Malusev"/>
        <meta property="og:description" content="Dušan's Website"/>
        <meta property="og:image" content="{{ asset('images/me.jpeg') }}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="{{ config('app.url') }}"/>
        <meta name="twitter:card" content="Dušan's Website"/>
        <meta name="twitter:image" content="{{ asset('images/me.jpeg') }}"/>
        <meta name="twitter:title" content="Dušan Malusev"/>
        <meta name="twitter:description"
              content="I'm an experienced remote software developer deeply passionate about creating efficient and elegant solutions"/>
        <meta name="author" content="Dušan Malusev"/>
    </x-slot:meta>
    <x-slot:structured>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "ProfilePage",
                "dateCreated": "2023-12-23T12:34:00+01:00",
                "dateModified": "2024-01-21T15:11:00+01:00",
                "mainEntity": {
                    "@type": "Person",
                    "name": "Dušan Malušev",
                    "alternateName": "dmalusev",
                    "identifier": "123475623",
                    "description": "I'm an experienced remote software developer deeply passionate about creating efficient and elegant solutions. My journey involves honing skills through diverse projects, all crafted within the confines of my remote workspace.",
                    "image": "https://avatars.githubusercontent.com/u/33778979",
                    "sameAs": [
                      "https://github.com/dmalusev",
                      "https://dev.to/malusev998",
                      "https://www.linkedin.com/in/malusevd998",
                      "https://www.reddit.com/user/Back_Professional",
                      "https://stackoverflow.com/users/8411483/dusan-malusev"
                    ]
                }
            }
        </script>
    </x-slot:structured>
    <article class="h-full flex flex-col items-center justify-center text-center">
        <header class="mb-3 flex flex-col items-center">
            <img
                    class="mb-2 h-36 w-36 rounded-full"
                    width="36"
                    height="36"
                    decoding="async"
                    alt="Dusan Malusev"
                    src="{{ asset('images/me.jpeg') }}"
            />
            <h1 class="text-4xl font-extrabold">
                Dušan Malušev
            </h1>
            <h2 class="text-xl text-neutral-400">
                Senior Software Developer
            </h2>
            <div class="mt-1 text-2xl">
                <x-profile-links/>
            </div>
        </header>
        <section class="prose-lg prose-invert"><br>
            Greetings 👋!
            <p>
                I'm an experienced remote software developer deeply passionate about creating efficient
                and elegant solutions. My journey involves honing skills through diverse projects, all crafted
                within the confines of my remote workspace.
            </p>

            <p>
                As an enthusiastic contributor and maintainer in the
                open source community, I firmly believe in the power of collaboration and giving back. Specializing
                in the Go, Rust, and PHP programming languages, I thrive on the challenges and opportunities they
                present. Join me in shaping the digital landscape, and let's build something remarkable together!
            </p>

        </section>
        <section class="prose-lg prose-invert mt-5">
            <p>
                If you find value in my work and would like to support ongoing projects, consider becoming a
                sponsor.
            </p>

            <div class="w-full">
                <iframe
                        src="https://github.com/sponsors/dmalusev/card"
                        title="Sponsor dmalusev"
                        style="border: 0;"
                        class="w-full"
                ></iframe>
            </div>

        </section>
    </article>
</x-layouts.website>