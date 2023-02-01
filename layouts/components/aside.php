<aside class="min-w-max w-40 p-3">
    <div class="grid gap-y-3 divide-y divide-gray-200">
        <?php if (isset($user)): ?>
            <a href="/profile.php" title="" class="px-3 py-1 font-bold text-gray-500 hover:text-gray-800">
                Profile
            </a>
        <?php endif; ?>

        <?php if (isset($user)): ?>
            <a href="../../forms/logout.php" title="Sign out" class="rounded px-3 py-1 font-bold text-gray-500 hover:text-gray-800">
                Sign out
            </a>
        <?php endif; ?>
    </div>
</aside>
