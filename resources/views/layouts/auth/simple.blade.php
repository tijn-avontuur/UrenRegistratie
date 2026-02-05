<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    @include('partials.head')

    <style>
        /* Smooth transitions for form elements */
        .input,
        .btn,
        .checkbox {
            transition: all 0.2s ease-in-out;
        }

        /* Custom focus styles */
        .input:focus {
            transform: translateY(-1px);
        }

        /* Button styling - no shadow */
        .btn-primary {
            background-color: #422AD5;
            border-color: #422AD5;
        }

        .btn-primary:hover:not(:disabled) {
            background-color: #3820b0;
            border-color: #3820b0;
            transform: translateY(-1px);
        }

        .btn-primary:active:not(:disabled) {
            transform: translateY(0);
        }

        /* Remove shadows from buttons */
        .btn {
            box-shadow: none !important;
        }

        /* Input borders */
        .input-bordered {
            border: 1px solid #d1d5db;
        }

        .input-bordered:focus {
            border-color: #422AD5;
            outline: none;
        }

        /* Loading spinner */
        .spinner {
            border: 2px solid #e5e7eb;
            border-top: 2px solid #422AD5;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 0.6s linear infinite;
            display: inline-block;
            margin-right: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Smooth page transitions */
        body {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-base-200 antialiased">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="flex w-full max-w-md mx-auto flex-col gap-6">
            {{ $slot }}
        </div>
    </div>
    @fluxScripts
</body>

</html>
