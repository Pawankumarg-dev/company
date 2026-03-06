<html>
    <head>
        <style>
            .main{
                width:816px;
            }
            .heading{
                text-align: center;
            }
            .main-heading{
                font-size: 14px;
                font-weight: bold;
            }
            .sub-heading{
                font-size:10px;
            }
            .block{
                width:34;

            }
            .block-black{
                background: black;
            }
            .title{
                font-size:12px;
                padding-top:8px;
                border-bottom: 2px solid #ccc;
                padding-bottom:20px;
            }
            .omr tr td{
                font-size: 10px;
                border: 1px solid rgb(216, 36, 117);
                border-radius: 10px;
                width: 10px;
                text-align: center;
            }
            .omr tr th{
                text-align: left;
            }
            .filler-column{
                width:10px;
                border:0px!important;
            }
            .top-align{
                vertical-align: top;
            }
            .content{
            }
            .no-border{
                border: 0!important;
            }
            .text-left{
                text-align: left!important;
            }
        </style>
    </head>
    <body>
        <table class="main">
  
            <tr>
                <td class="block block-black" rowspan="2"></td>
                <td class="heading main-heading" style="width:748px;">
                    National Board of Examination in Rehabilitation(NBER), New Delhi. 
                </td>
                <td class="block block-black" rowspan="2"></td>
            </tr>
            <tr>
                <td class="heading sub-heading">
                    An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment 
                </td>
            </tr>
            <tr>
                <td class="block " rowspan="2"></td>
                <td style="height: 300px;border:1px solid #333;">

                </td>
                <td class="block " rowspan="2"></td>
            </tr>
            <tr>
                <td class="block" ></td>
                <td class="empty">
                   
                </td>
                <td class="block" ></td>
            </tr>
            <tr class="content">
                <td class="block"></td>
                <td>
                   <table>
                        <tr>
                            <td class="title">
                                Name:
                            </td>
                            <td class="filler-column"></td>
                            <td class="title" colspan="2">
                                Exam Center Code:
                            </td>
                            <td class="filler-column"></td>
                            <td class="title" colspan="2">
                                Institute Code
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="omr">
                                    <?php $max = 30; ?>
                                    @include('omr.char')
                                </table>
                            </td>
                            <td class="filler-column"></td>
                            <td>
                                <table class="omr">
                                    <?php $max = 4; ?>
                                    @include('omr.char')
                                </table>
                            </td>
                            <td class="top-align">
                                <table class="omr">
                                    <?php $max = 2; ?>
                                    @include('omr.digit')
                                </table>
                            </td>
                            <td class="filler-column"></td>
                            <td>
                                <table class="omr">
                                    <?php $max = 2; ?>
                                    @include('omr.char')
                                </table>
                            </td>
                            <td class="top-align">
                                <table class="omr" >
                                    <?php $max = 3; ?>
                                    @include('omr.digit')
                                </table>
                            </td>
                        </tr>
                   </table>
                </td>
                <td class="block" ></td>
            </tr>
            
            <tr class="content">
                <td class="block"></td>
                <td>
                   <table>
                        <tr>
                       
                            <td class="title">
                                Enrolment Number
                            </td>
                            <td class="filler-column"></td>
                            <td class="title">
                                Course Code
                            </td>
                            <td class="filler-column"></td>
                            <td class="title" >
                                Subject ID
                            </td>
                            <td class="filler-column"></td>
                            <td class="title" >
                                Term
                            </td>
                            <td class="filler-column"></td>
                            <td class="title" >
                                Exam Date <span style="color: #888;">(DDMMYYYY)</span>
                            </td>
                            <td class="filler-column"></td>
                            <td class="title" >
                                Session
                            </td>
                        </tr>
                        <tr>
                            <td class="top-align">
                                <table class="omr">
                                    <?php $max = 11; ?>
                                    @include('omr.digit')
                                </table>
                            </td>
                            
                            <td class="filler-column"></td>
                            <td class="top-align">
                                <table class="omr">
                                    <?php $max = 4; ?>
                                    @include('omr.digit')
                                </table>
                            </td>
                            <td class="filler-column"></td>
                            <td class="top-align">
                                <table class="omr">
                                    <?php $max = 3; ?>
                                    @include('omr.digit')
                                </table>
                            </td>
                            <td class="filler-column"></td>
                            <td class="top-align">
                                <table class="omr">
                                   <tr>
                                        <td>&nbsp;</td>
                                        <td class="no-border text-left">I</td>
                                   </tr>
                                   <tr>
                                    <td>&nbsp;</td>
                                    <td class="no-border text-left">II</td>
                               </tr>
                                </table>
                            </td>
                            <td class="filler-column"></td>
                            <td class="top-align">
                                <table class="omr">
                                    <?php $max = 8; ?>
                                    @include('omr.digit')
                                </table>
                            </td>
                            <td class="filler-column"></td>
                            <td class="top-align">
                                <table class="omr">
                                   <tr>
                                        <td>&nbsp;</td>
                                        <td class="no-border text-left">Morning</td>
                                   </tr>
                                   <tr>
                                    <td>&nbsp;</td>
                                    <td class="no-border text-left">Noon</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                   </table>
                </td>
                <td class="block" ></td>
            </tr>
            <tr>
                <td class="block block-black" rowspan="2"></td>
                <td class="heading main-heading" style="color: #fff;height:38px;">
                    National Board of Examination in Rehabilitation(NBER), New Delhi. 
                </td>
                <td class="bloc block-black" rowspan="2"></td>
            </tr>
        </table>
    </body>
</html>



<tr>
    <td>
       
    </td>
    <td>
       
    </td>
</tr>