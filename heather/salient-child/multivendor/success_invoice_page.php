<?php
if( isset($_GET['session_id']) ){

    $checkout_id = $_GET['session_id'];
    $args = [
        'post_type'   =>  'invoices',
        'post_status' => 'publish',
        'meta_query'     => [
            [
                'key'      => 'checkout_id',
                'value'    =>  $checkout_id,
                'compare'   => '='
            ]
        ],
    ];
    $invoices = new WP_Query($args);
    
    $status = get_post_meta($invoices->posts[0]->ID, 'status', true);
    if($status == 'unpaid'){
        update_post_meta($invoices->posts[0]->ID, 'status', 'paid');
        update_post_meta($invoices->posts[0]->ID, 'completion_date', date("d F Y"));
        $redirect = home_url('success');
        echo "<script>
          
            window.location.href = '{$redirect}';
        </script>";
        exit;
       
    }
}  
?>
<div class="card">
    <div class="header">
        <div class="image">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M20 7L9.00004 18L3.99994 13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>
        </div>
        <div class="content">

            <span class="title">Success</span>
            <p class="message">We sincerely appreciate your prompt payment. Your transaction has been successfully processed, and your support means a lot to us</p>
        </div>
       
    </div>
</div>


<style>
    .card {
    margin-left: auto;
    margin-right: auto;
    text-align: left;
    border-radius: 0.5rem;
    max-width: 590px;
    min-height: 200px;
    margin-top: 50px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    background-color: #fff;
    }


    .header {
    padding: 1.25rem 1rem 1rem 1rem;
    }

    .image {
    display: flex;
    margin-left: auto;
    margin-right: auto;
    background-color: #e2feee;
    flex-shrink: 0;
    justify-content: center;
    align-items: center;
    width: 3rem;
    height: 3rem;
    border-radius: 9999px;
    animation: animate .6s linear alternate-reverse infinite;
    transition: .6s ease;
    }

    .image svg {
    color: #0afa2a;
    width: 2rem;
    height: 2rem;
    }

    .content {
    margin-top: 0.75rem;
    text-align: center;
    }

    .title {
    color: #066e29;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.5rem;
    }

    .message {
    margin-top: 0.5rem;
    color: #595b5f;
    font-size: 1rem;
    line-height: 1.25rem;
    }


    @keyframes animate {
    from {
        transform: scale(1);
    }

    to {
        transform: scale(1.09);
    }
    }
</style>