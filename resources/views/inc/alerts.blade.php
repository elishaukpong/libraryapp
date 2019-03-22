
            {{-- @auth
            @if ($user->email_verified_at == null)
                <script>
                    swal("Your account is not verified!","", "info",{
                        buttons: ["Verify", "Cancel"],
                    });
                </script>
            @endif
            @endauth --}}
            @if (session('success'))
                <script>
                   toastr.success(" {{session('success')}} ")
                </script>
            @endif
            @if (session('update-success'))
                <script>
                   toastr.success(" {{session('update-success')}} ")
                </script>
            @endif

            @if (session('error'))
                <script>
                    toastr.error("{{ session('error') }}");
                </script>
            @endif
            @if (session('info'))
            <script>
               toastr.info(" {{session('info')}} ")
            </script>
            @endif

            {{-- SWAL ALERTS --}}
            @if (session('swal-info'))
            <script>
                swal(" {{session('swal-info')}} ", "", "info")
            </script>
            @endif

            @if (session('swal-success'))
            <script>
                swal(" {{session('swal-success')}} ", "", "success")
            </script>
            @endif
