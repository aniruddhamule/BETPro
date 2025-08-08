@if ($errors->any())
   @foreach ($errors->all() as $error)
      <script>
         (function($) {
            "use strict";
         toastr.warning('{{ $error }}')
         })(jQuery);
      </script>
   @endforeach
   @endif
   @if (Session::has('message'))
   <script>
      (function($) {
      "use strict";
      toastr.success('{{ Session::get('message') }}');
      })(jQuery);
   </script>
   @endif
   @if(session()->has('success'))
   <script>
      (function($) {
            "use strict";
            toastr.success('{{ session()->get('success') }}')
      })(jQuery);
   </script>
   @endif
   @if(session()->has('alert'))
   <script>
   (function($) {
        "use strict";
         toastr.error('{{ session()->get('alert') }}')
      })(jQuery);
   </script>
   @endif