<x-guest-layout>
    <form action="{{ route('login') }}" method="post" class="flex flex-col gap-2 p-5">

        @csrf
        <h1 class="text-3xl font-bold tracking-widest text-center text-accent">Login</h1>
        <div class="flex flex-col gap-2">
            <label for="" class="text-base text-accent">Email</label>
            <input type="email" name="email" class="w-full input input-accent" placeholder="admin@admin.com">

            @if ($errors->has('email'))
                <p class="text-xs text-error">{{ $errors->first('email') }}</p>
            @endif
        </div>


        <div class="flex flex-col gap-2">
            <label for="" class="text-base text-accent">Password</label>
            <input type="password" name="password" class="w-full input input-accent" placeholder="password">
            @if ($errors->has('password'))
                <p class="text-xs text-error">{{ $errors->first('password') }}</p>
            @endif
        </div>
        <button class="btn btn-accent text-primary ">Login</button>
    </form>
</x-guest-layout>
