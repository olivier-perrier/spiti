<x-guest-layout>

    <div class="flex justify-center mt-10">

        <form action="{{route("register")}}" method="post">
            @csrf

            <input type="hidden" name="token" value="{{ request()->token }}">

            <div class="space-y-4">

                <div>
                    <label for="name">Nom Prénom</label>
                    <input type="text" value="" name="name">
                </div>

                <div>
                    <label for="password">Mot de passe</label>
                    <input type="text" value="" name="password">
                </div>
                <div>
                    <label for="password">Confirmation du mot de passe</label>
                    <input type="text" value="" name="password_confirmation">
                </div>

                <button type="submit">Rejoindre</button>

            </div>

            @foreach ($errors->all() as $error)
                <div class="text-red-500">{{ $error }}</div>
            @endforeach

        </form>

    </div>

</x-guest-layout>
