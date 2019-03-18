@extends('mails.master')

@section('content')
    <p>Dear {{$user->name}},</p>
    <p>
        Thank you for registering on our website. We appreciate your willingness to work with us. However, before we accept you as one of our writers, we would like to evaluate your writing skills. As such, please write a two-page essay on the topic "Legalization of Marijuana" and forward it to {{$user->email}} within at most 72hours of your receiving of this email. The sooner you forward the sample paper, the better. Please try to adhere to the following guidelines:
        1.	Make sure that your paper has impeccable grammar. We do not necessarily require you to use sophisticated grammar. All we ask for is that your grammar should be free-flowing, easy to understand and devoid of obvious grammatical mistakes.
        2.	Try to organize your essay into five paragraphs. Let the first paragraph introduce the topic, the next three paragraphs form the body of your essay, and, finally, use the last paragraph to conclude your essay
        3.	Make sure you use at least five sources in your paper. Use APA citation style to reference and format your paper. If you are not familiar with APA 6th edition citation style, you can visit http://owl.english.purdue.edu/owl/resource/560/01/. Also, please check the files in the attached Files.zip folder. They should help you format your paper. One of the papers is a sample paper formatted in APA 6th edition style. As you can see from that sample, APA requires that pages should be double-spaced, font 12, Times New Roman or Arial, 1" margins all-round the paper, amongst other guidelines.
        4.	DO NOT PLAGIARIZE. Try not to copy and paste directly from the internet or other sources unless you give due credit to your sources by adequately and properly referencing using APA citation style. Even if you properly reference your papers, content directly copied from online sources should not exceed 10%.
        NB: THE SAMPLE PAPER WILL BE RUN THROUGH A PLAGIARISM CHECKER. PLAGIARIZED SAMPLES WILL BE REJECTED.

        Once again, thank you for your time and interest in us. We are looking forward to your reply.

    </p>
    {{--<h3> {!! $data['title'] !!} </h3>--}}
    {{--<p>{{$data['message']}}</p>--}}
    @endsection
