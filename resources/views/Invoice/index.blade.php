<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="alert bg-green-100 rounded-lg py-5 px-6 mb-3 text-base text-green-700 inline-flex items-center w-full alert-dismissible fade show"
                        role="alert">
                        <strong class="mr-1">Success </strong>
                        {{ session('success') }}
                        <button type="button"
                            class="btn-close box-content w-4 h-4 p-1 ml-auto text-yellow-900 border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-yellow-900 hover:opacity-75 hover:no-underline"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert bg-red-100 rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full alert-dismissible fade show"
                        role="alert">
                        {{ session('error') }}
                        <button type="button"
                            class="btn-close box-content w-4 h-4 p-1 ml-auto text-red-900 border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-red-900 hover:opacity-75 hover:no-underline"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form method="POST" action="{{ route('invoice.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="flex items-center justify-start">
                                <div class="datepicker relative form-floating mb-3 xl:w-96">
                                    <label for="floatingInput" class="text-gray-700">Select a date</label>
                                    <input type="date" name="invoice_date" id="invoice_date"
                                        class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" required
                                        placeholder="Select a date" />
                                </div>
                            </div>

                            <table class="min-w-full" id="invoice-table">
                                <thead class="border-b">
                                    <tr>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            #
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            Item
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            Price(₹)
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            QTY
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                                            colspan="2">
                                            Tax (%)
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            Total(₹)
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="_invoice-body">
                                    <tr class="border-b">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 _row-index">
                                            1
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <x-text-input type="text" name="name[]" class="block mt-1 w-full _row-item"
                                                required placeholder="Item Name" />
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <x-text-input type="number" name="price[]"
                                                class="block mt-1 w-full _row-price" min=0 required
                                                placeholder="Item Price in ₹" oninput="validity.valid||(value='');" />
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <x-text-input type="number" name="qty[]" class="block mt-1 w-full _row-qty"
                                                min=0 required placeholder="Total Quantitty"
                                                oninput="validity.valid||(value='');" />
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <x-text-input type="number" class="block mt-1 w-full _row-tax" required
                                                min=0 placeholder="Tax (%)" oninput="validity.valid||(value='');" />
                                        </td>
                                        <td
                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
                                            <x-text-input type="hidden" name="tax[]"
                                                class="block mt-1 w-full _row-tax-total" required
                                                placeholder="Tax Ammount" readonly />

                                            <span class="_row-tax-total-span">₹ 0.00</span>
                                        </td>
                                        <td
                                            class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
                                            <x-text-input type="hidden" name="total[]"
                                                class="block mt-1 w-full _row-total" required
                                                placeholder="Total Ammount" readonly />
                                            <span class="_row-total-span">₹ 0.00</span>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="inline-block rounded-full bg-blue-600 text-white leading-normal uppercase shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-8 h-8 _add-row">
                                                +
                                            </button>
                                            <button type="button"
                                                class="inline-block rounded-full bg-orange-600 text-white leading-normal uppercase shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out w-8 h-8 _rm-row">
                                                -
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="min-w-full">

                                <tr class="border-b">
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Total</td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        <span id="total-amount">
                                            ₹ 0.00
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Tax (18%)</td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        <x-text-input type="hidden" name="tax_total" id="tax-total" readonly />
                                        <span id="tax-total-span">
                                            ₹ 0.00
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left"><strong>Total
                                            Amount</strong></td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        <x-text-input type="hidden" name="net_total" id="net-total" readonly />
                                        <span id="net-total-span">
                                            <strong>
                                                ₹ 0.00
                                            </strong>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        <div class="flex justify-start">
                                            <div class="mb-3 w-96">
                                                <label for="formFileMultiple"
                                                    class="form-label inline-block mb-2 text-gray-700">Upload reciept or
                                                    bill <small>(Max 3 MB, file only support JPG, PNG and
                                                        PDF)</small></label>
                                                <input
                                                    class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                    type="file" id="invoice_file" name="invoice_file">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div class="flex space-x-2 justify-end">
                                <button type="submit" data-mdb-ripple="true" data-mdb-ripple-color="light"
                                    class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Save</button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

        @push('scripts')

        <script type="module">
            /** validate form for add-row button */
        function validateRow(_tr) {
            var flag = 0;

            if (_tr.find('._row-item').val() == '') {
                alert ('Please enter Product name.!');
                flag = 1;
            }

            if (_tr.find('._row-price').val() == '') {
                alert ('Please enter Product price.!');
                flag = 1;
            }

            if (_tr.find('._row-qty').val() == '') {
                alert ('Please enter Product quantity.!');
                flag = 1;
            }

            if (_tr.find('._row-tax').val() == '') {
                alert ('Please enter Product tax.!');                
                flag = 1;
            }

            if (flag == 1) {
                return false;
            }

            return true;
        }

        /** add row button click action for invoice table */
        $('body').on('click', '._add-row', function () {
            /** cloning last tr of the table for next row */
            var _tr =   $(this).closest('tr');
            var _clone = _tr.clone();

            /** validadte product name input */
            if (!validateRow(_tr)) {
                return false;
            }

            /** resetting all inputs */
            _clone.find(':input').val('');

            _tr.after(_clone);

            /** hiding add-row button from current row */
            $(this).css('display', 'none');

            caclcuateRowTotal();
        })
  
        /** remove row button click action for invoice table */
        $('body').on('click', '._rm-row', function () {
            /** check whether the active row is the only child or not */
            if ($(this).closest('tr').is('tr:only-child')) {
                $(this).closest('tr').find(':input').val('');

                caclcuateRowTotal();
                return false;
            }

            $(this).closest('tr').remove();

            /**
             * show add-row button to the last row
             */
            $('#invoice-table tr:last').find('._add-row').show();

            caclcuateRowTotal();
        })

        $('body').on('keyup', '._row-price, ._row-qty, ._row-tax', function () {
            caclcuateRowTotal();

            /** TODO: optimize code to calculate only current row values on change event */
        })

        /** function to calculate row total */
        function caclcuateRowTotal() {
            var _total_amount = 0;
            var _tax_total = 0;
            var _net_total = 0;

            $("#_invoice-body > tr").each(function (index) {
                let _row = $(this);
                _row.find('._row-index').text(index + 1);

                /** row input validation */

                /** fetch values from inputs */
                let _price = !isNaN(parseFloat(_row.find('._row-price').val())) ? parseFloat(_row.find('._row-price').val()) : 0;
                let _qty = !isNaN(parseFloat(_row.find('._row-qty').val())) ? parseFloat(_row.find('._row-qty').val()) : 0;
                let _tax = !isNaN(parseFloat(_row.find('._row-tax').val())) ? parseFloat(_row.find('._row-tax').val()) : 0;
                
                // if (_price > 0 && _qty > 0 && _tax >= 0) {
                    /** calculate row taax total */
                    let _row_sub_total = _price * _qty;

                    /** calculate row total */
                    let _row_tax_total = (_row_sub_total * _tax) / 100
                    _row.find('._row-tax-total').val(_row_tax_total.toFixed(2));
                    _row.find('._row-tax-total-span').text("₹ "+_row_tax_total.toFixed(2));

                    let _row_net_total = _row_sub_total + _row_tax_total;
                    _row.find('._row-total').val(_row_net_total.toFixed(2));
                    _row.find('._row-total-span').text("₹ "+_row_net_total.toFixed(2));

                    /** calculate tax total */
                    _tax_total += _row_tax_total;
                    $('#tax-total').val(_tax_total.toFixed(2));
                    $('#tax-total-span').text("₹ "+_tax_total.toFixed(2));

                    /** calculate net total */
                    _net_total += _row_net_total;
                    $('#net-total').val(_net_total.toFixed(2));
                    $('#net-total-span').text("₹ "+_net_total.toFixed(2));

                    $('#total-amount').text("₹ "+(_net_total - _tax_total).toFixed(2));
                // }
            });
        }
        
        $('#invoice_file').on('change', function () {
            var file = $(this);

            let allowedMimes = ['png', 'jpg', 'jpeg', 'pdf']; //allowed image mime types
            let maxMb = 3; //maximum allowed size (MB)

            if (!file.val()) { // if the image input does not have value
                alert ('No image selected :(');
                return false;
            }

            /** file type validation */
            let mime = file.val().split('.').pop(); // get the extension/mime of image file
            if (!allowedMimes.includes(mime)) {  // if allowedMimes array does not have the extension
                alert("Only png, jpg, jpeg, pdf files are alowed");
            }

            /** file ize */
            let kb = $(this)[0].files[0].size / 1024; // convert the file size into byte to kb
            let mb = kb / 1024; // convert kb to mb
            if (mb > maxMb) { // if the file size is gratter than maxMb
                alert (`File should be less than ${maxMb} MB`);
                this.value = "";
                return false;
            }
        })
        </script>

        @endpush


</x-app-layout>