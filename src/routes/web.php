<?php

use Illuminate\Support\Facades\Route;
use App\Events\classesRoomEvent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// qna 다운로드 접속 방지
//Route::get('/public/storage/qna/{file_name}', function() {
//   return redirect()->back();
//});

//다운로드 방지
Route::get('/public/storage/', function() {
    return redirect()->back();
});

// Root
Route::get('/', function() { return redirect()->route('user.loginView'); });

// Logout
Route::get('/logout', 'UserController@logout')->name('user.logout');

/** UserController */
Route::middleware('guest')->group(function () {
    Route::get('/login', 'UserController@loginView')->name('user.loginView');
    Route::post('/login', 'UserController@login')->name('user.login');
    Route::get('/register', 'UserController@registerView')->name('user.registerView');
    Route::post('/register', 'UserController@register')->name('user.register');
    Route::get('/plush_register', 'UserController@plushRegisterView')->name('user.plushRegisterView');
    Route::get('/register', 'UserController@registerView')->name('user.registerView');
    Route::post('/register', 'UserController@register')->name('user.register');
    Route::get('/email_verify', 'UserController@emailVerify')->name('user.emailVerify');
    Route::get('/find_id', 'UserController@findIdView')->name('user.findIdView');
    Route::post('/find_id', 'UserController@findId')->name('user.findId');
    Route::get('/find_pw', 'UserController@findPwView')->name('user.findPwView');
    Route::post('/find_pw', 'UserController@findPw')->name('user.findPw');
    Route::get('/resent_verification_email', 'UserController@resendVerificationEmail')->name('user.emailReverify');
    Route::get('/email_already_exist', 'UserController@emailAlreadyExist')->name('user.emailAlreadyExist');

    /** Social Authentication */
    Route::get('/auth/facebook/login', 'SocialAuthController@facebookRedirectToProvider')->name('auth.facebook.login');
    Route::get('/auth/facebook/callback', 'SocialAuthController@facebookHandleProviderCallback')->name('auth.facebook.callback');
    Route::get('/auth/google/login', 'SocialAuthController@googleRedirectToProvider')->name('auth.google.login');
    Route::get('/auth/google/callback', 'SocialAuthController@googleHandleProviderCallback')->name('auth.google.callback');
    Route::get('/auth/naver/login', 'SocialAuthController@naverRedirectToProvider')->name('auth.naver.login');
    Route::get('/auth/naver/callback', 'SocialAuthController@naverHandleProviderCallback')->name('auth.naver.callback');
    Route::get('/auth/kakao/login', 'SocialAuthController@kakaoRedirectToProvider')->name('auth.kakao.login');
    Route::get('/auth/kakao/callback', 'SocialAuthController@kakaoHandleProviderCallback')->name('auth.kakao.callback');

});

Route::middleware('auth')->group(function () {
    Route::get('/test', 'testController@test');

    /** LectureController */
    Route::get('/lecture', 'LectureController@mainView')->name('lecture.mainView');
    Route::post('/lecture', 'LectureController@join')->name('lecture.join');
    Route::get('/lecture/write', 'LectureController@writeView')->name('lecture.writeView');
    Route::post('/lecture/write', 'LectureController@write')->name('lecture.write');
    Route::get('/lecture/edit/{id}', 'LectureController@editView')->name('lecture.editView');
    Route::post('/lecture/edit/{id}', 'LectureController@edit')->name('lecture.edit');
    Route::get('/lecture/delete/{id}', 'LectureController@delete')->name('lecture.delete');

    /** 강의 수정페이지에서 코드 Refresh 버튼 클릭 시 코드 재생성을 위한 루트 */
    Route::get('/lecture/refresh-lecture-code', 'LectureController@createLectureCode')->name('lecture.createLectureCode');

    /** 교수|학생이 접근 가능한 페이지 lecture_id를 URL에 포함하여야함. */
    Route::get('/lecture/{lecture_id}', 'LectureController@lectureView')->name('lecture.lectureView');
    Route::get('/lecture/info/{lecture_id}', 'LectureController@infoView')->name('lecture.infoView');
    Route::get('/lecture/analysis/{lecture_id}', 'LectureController@analysisView')->name('lecture.analysisView');
    Route::get('/lecture/analysis/{lecture_id}/analysis/{class_id}/student', 'LectureController@analysisStudentDetailView')->name('lecture.analysis.student.detailView');
    Route::get('/lecture/analysis/{lecture_id}/analysis/{class_id}/graph', 'LectureController@analysisGraphDetailView')->name('lecture.analysis.graph.detailView');
    Route::get('/lecture/analysis/{lecture_id}/analysis/{class_id}/list', 'LectureController@analysisListDetailView')->name('lecture.analysis.list.detailView');

    /** qnd */
    Route::get('/lecture/{lecture_id}/qna', 'LectureController@qnaView')->name('lecture.qnaView');
    Route::get('/lecture/{lecture_id}/qna/write', 'LectureController@qnaWriteView')->name('lecture.qna.writeView');
    Route::post('/lecture/{lecture_id}/qna/write', 'LectureController@qnaWrite')->name('lecture.qna.write');
    Route::get('/lecture/{lecture_id}/qna/{qna_id}/edit', 'LectureController@qnaEditView')->name('lecture.qna.editView');
    Route::get('/lecture/{lecture_id}/qna/{qna_id}', 'LectureController@qnaDetailView')->name('lecture.qna.detailView');
    Route::post('/lecture/{lecture_id}/qna/{qna_id}/edit', 'LectureController@qnaEdit')->name('lecture.qna.edit');
    Route::get('/lecture/{lecture_id}/qna/{qna_id}/delete', 'LectureController@qnaDelete')->name('lecture.qna.delete');
    Route::get('/lecture/{lecture_id}/qna/{qna_id}/{file_name}', 'DownloadController@qnaDownload')->name('lecture.qna.download');
    Route::post('/lecture/{lecture_id}/qna/{qna_id}', 'LectureController@qnaCommentWrite')->name('lecture.qna.comment.write');
    Route::get('/lecture/{lecture_id}/qna/{qna_id}/comment/{comment_id}', 'LectureController@qnaCommentDelete')->name('lecture.qna.comment.delete');

    /** notice */
    Route::get('/lecture/{lecture_id}/notice', 'LectureController@noticeView')->name('lecture.noticeView');
    Route::get('/lecture/{lecture_id}/notice/write', 'LectureController@noticeWriteView')->name('lecture.notice.writeView');
    Route::post('/lecture/{lecture_id}/notice/write', 'LectureController@noticeWrite')->name('lecture.notice.write');
    Route::get('/lecture/{lecture_id}/notice/{notice_id}/edit', 'LectureController@noticeEditView')->name('lecture.notice.editView');
    Route::get('/lecture/{lecture_id}/notice/{notice_id}', 'LectureController@noticeDetailView')->name('lecture.notice.detailView');
    Route::post('/lecture/{lecture_id}/notice/{notice_id}/edit', 'LectureController@noticeEdit')->name('lecture.notice.edit');
    Route::get('/lecture/{lecture_id}/notice/{notice_id}/delete', 'LectureController@noticeDelete')->name('lecture.notice.delete');
    Route::get('/lecture/{lecture_id}/notice/{notice_id}/{file_name}', 'DownloadController@noticeDownload')->name('lecture.notice.download');

    /** archive */
    Route::get('/lecture/{lecture_id}/archive', 'LectureController@archiveView')->name('lecture.archiveView');
    Route::get('/lecture/{lecture_id}/archive/write', 'LectureController@archiveWriteView')->name('lecture.archive.writeView');
    Route::post('/lecture/{lecture_id}/archive/write', 'LectureController@archiveWrite')->name('lecture.archive.write');
    Route::get('/lecture/{lecture_id}/archive/{archive_id}/edit', 'LectureController@archiveEditView')->name('lecture.archive.editView');
    Route::get('/lecture/{lecture_id}/archive/{archive_id}', 'LectureController@archiveDetailView')->name('lecture.archive.detailView');
    Route::post('/lecture/{lecture_id}/archive/{archive_id}/edit', 'LectureController@archiveEdit')->name('lecture.archive.edit');
    Route::get('/lecture/{lecture_id}/archive/{archive_id}/delete', 'LectureController@archiveDelete')->name('lecture.archive.delete');
    Route::get('/lecture/{lecture_id}/archive/{archive_id}/{file_name}', 'DownloadController@archiveDownload')->name('lecture.archive.download');

    /** ClassController */
    Route::get('/lecture/{lecture_id}/class', 'ClassController@mainView')->name('class.mainView');
    Route::get('/lecture/{lecture_id}/class/write', 'ClassController@writeView')->name('class.writeView');
    Route::post('/lecture/{lecture_id}/class/write', 'ClassController@write')->name('class.write');
    Route::get('/lecture/{lecture_id}/class/{class_id}/edit', 'ClassController@editView')->name('class.editView');
    Route::post('/lecture/{lecture_id}/class/{class_id}/edit', 'ClassController@edit')->name('class.edit');
    Route::get('/lecture/{lecture_id}/class/{class_id}/delete', 'ClassController@delete')->name('class.delete');

    /** SlideController */
    Route::get('/lecture/{lecture_id}/class/{class_id}/slide/write', 'SlideController@writeView')->name('slide.writeView');
    Route::post('/lecture/{lecture_id}/class/{class_id}/slide/write', 'SlideController@makeSlide')->name('slide.makeSlide');
    Route::post('/lecture/{lecture_id}/class/{class_id}/slide/write/pptUpload', 'SlideController@pptUpload')->name('slide.pptUpload');
    Route::get('/lecture/{lecture_id}/class/{class_id}/slide/write/fetchSlides', 'SlideController@fetchSlides')->name('slide.fetchSlides');

    Route::get('/lecture/{lecture_id}/class/{class_id}/slide/write/slideExCheck', 'SlideController@slideExCheck')->name('slide.slideExCheck');
    Route::post('/lecture/{lecture_id}/class/{class_id}/slide/write/slideExCheck', 'SlideController@slideExOn')->name('slide.slideExOn');

    Route::get('/lecture/{lecture_id}/class/{class_id}/slide/write/deleteSlide/{slide_id}', 'SlideController@deleteSlide')->name('slide.deleteSlide');
    Route::post('/lecture/{lecture_id}/class/{class_id}/slide/write/{slide_id}', 'SlideController@writeSlide')->name('slide.writeSlide');
    Route::post('/lecture/{lecture_id}/class/{class_id}/slide/write/{slide_id}/image', 'SlideController@imageUpload')->name('slide.imageUpload');
    Route::get('/lecture/{lecture_id}/class/{class_id}/slide/write/{slide_id}/image/{file_name}', 'DownloadController@slideImageDownload')->name('slide.image.download');
    Route::get('/lecture/{lecture_id}/class/{class_id}/slide/write/image/{file_name}', 'DownloadController@_slideImageDownload');

    //slideMove
    Route::post('/lecture/{lecture_id}/class/{class_id}/slide/write/handle/slideMove', 'SlideController@slideMove')->name('slide.slideMove');


    /** EnterController */
    Route::get('/lecture/{lecture_id}/class/{class_id}/progress', 'ProgressController@enterProgress')->name('progress.enter');

    /** ProgressController */


    /** myPage */
    Route::get('/mypage/myinfo', 'UserController@myInfoView')->name('user.myInfoView');
    Route::post('/mypage/myinfo', 'UserController@myInfoChange')->name('user.myInfoChange');
    ROute::get('/mypage/myinfo/secession', 'UserController@myInfoSecessionView')->name('user.secessionView');
    ROute::post('/mypage/myinfo/secession', 'UserController@myInfoSecession')->name('user.secession');

    Route::get('/mypage/payment', 'UserController@paymentView')->name('user.paymentView');
    Route::get('/mypage/billing', 'UserController@billingView')->name('user.billingView');
});

Route::middleware('room')->group(function () {
    Route::get('/room/{user_url}', 'ProgressController@enterProgress')->name('study.enter');
    Route::get('/room/{user_url}/api/fetchSlide/{slide_id}', 'ProgressController@fetchSlide');

    Route::get('/room/{user_url}/api/downloadImage/{file_name}', 'DownloadController@__slideImageDownload');

    Route::get('/room/{user_url}/api/statusUpdate/{slide_id}/{status}', 'ProgressController@statusUpdate');
    Route::post('/room/{user_url}/api/sendAnswer/{slide_id}', 'ProgressController@snedAnswer');

    Route::post('/room/{user_url}/api/sendReaction/{slide_id}', 'ProgressController@sendReaction');
    Route::get('/room/{user_url}/api/fetchReaction/{slide_id}', 'ProgressController@fetchReaction');

    //chat
    Route::get('/room/{user_url}/api/fetchMessages', 'ProgressController@fetchMessages');
    Route::post('/room/{user_url}/api/sendMessage', 'ProgressController@sendMessage');

    Route::get('/room/{user_url}/api/sendMemberCount', 'ProgressController@sendMemberCount');


    Route::get('/room/{user_url}/api/graphUpdate/{slide_id}', 'ProgressController@graphUpdate');
    Route::post('/room/{user_url}/api/leaderUpdate/{slide_id}', 'ProgressController@leaderUpdate');


});

Route::get('/request/write', 'RequestController@requestWriteView')->name('request.writeView');
Route::post('/request/write', 'RequestController@requestWrite')->name('request.write');

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

//test
//Route::get('/test', 'TestController@test');
//
//Route::get('/home', 'HomeController@index')->name('home');
//
//Route::get('/lecture/create', 'HomeController@createLecture')->name('lecture.create');
//
//Route::post('/lecture/create', 'LectureController@create')->name('lecture.create.submit');3
//Route::get('/lecture/delete/{id}', 'LectureController@delete')->name('lecture.delete');
//
//Route::get('/lecture/edit/{id}', 'LectureController@edit');
//Route::post('/lecture/edit/submit', 'LectureController@editSubmit')->name('lecture.edit.submit');
//Route::post('/home/participation', 'HomeController@participation')->name('home.participation');
//
//Route::get('/classes/{lecture_id}', 'ClassesController@index')->name('classes.classes');
////Route::get('/classes/{lecture_id}/create', 'ClassesController@createIndex')->name('classes.create');
//Route::post('/classes/create/submit', 'ClassesController@submit')->name('classes.submit');
//Route::get('/classes/edit/{lecture_id}/{id}', 'ClassesController@editIndex')->name('classes.edit');
//Route::post('/classes/edit/{id}', 'ClassesController@editSubmit')->name('classes.editSubmit');
//Route::get('/classes/delete/{lecture_id}/{id}', 'ClassesController@delete')->name('classes.delete');
//
////추가 되는 부분
//Route::post('/classes/notice/submit', 'ClassesController@noticeSubmit')->name('classes.notice.submit');
//
//
//
////수업 시작하기 버튼
//Route::get('/classes/{lecture_id}/create/{classes_id}', 'ClassesController@createClass')->name('classes.createClass');
//Route::get('/classes/{lecture_id}/create/{classes_id}/api/fetch_slides', 'ClassesController@fetchSlides');
//Route::post('/classes/{lecture_id}/create/{classes_id}/api/send_slides', 'ClassesController@sendSlides');
//Route::post('/classes/{lecture_id}/create/{classes_id}/api/delete_slides', 'ClassesController@deleteSlide');
//Route::post('/classes/{lecture_id}/create/{classes_id}/api/update_slides/{slide_id}', 'ClassesController@updateSlide');
//Route::post('/classes/{lecture_id}/create/{classes_id}/api/file_upload', 'ClassesController@fileUpload');
//Route::post('/classes/{lecture_id}/create/{classes_id}/api/update_all', 'ClassesController@allUpdate');
////pptFileUpload
//Route::post('/classes/{lecture_id}/create/{classes_id}/api/ppt_upload', 'ClassesController@pptUpload');
//
//
////사라저야 할것들
//Route::get('/classes/{lecture_id}/room/{classes_id}/api/fetch_slides', 'ClassesController@fetchSlides');
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/send_slides', 'ClassesController@sendSlides');
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/delete_slides', 'ClassesController@deleteSlide');
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/update_slides/{slide_id}', 'ClassesController@updateSlide');
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/file_upload', 'ClassesController@fileUpload');
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/update_all', 'ClassesController@allUpdate');
//
//

//수업진행중 api들
//
////공용
//Route::get('/classes/{lecture_id}/room/{classes_id}', 'ClassesController@roomIndex')->name('classes.roomIndex');
//Route::get('/classes/{lecture_id}/room/{classes_id}/api/get_goods/{slide_id}', 'SlideController@getGoods');
//
////교수
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/professor/fetch_slide', 'SlideController@fetchSlides');
//Route::get('/classes/{lecture_id}/room/{classes_id}/api/professor/get_members', 'SlideController@getMembers');
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/professor/send_answers', 'SlideController@sendAnswers');
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/user/quiz_result', 'SlideController@userQuizResult');
//
//
////학생
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/user/fetch_slide', 'SlideController@userFetchSlide');
//Route::get('/classes/{lecture_id}/room/{classes_id}/api/user/get_quiz_state', 'SlideController@getQuizState');
//Route::get('/classes/{lecture_id}/room/{classes_id}/api/user/get_answers/{slide_id}', 'SlideController@getAnswers');
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/user/quiz_result', 'SlideController@userQuizResult');
//Route::post('/classes/{lecture_id}/room/{classes_id}/api/user/send_goods', 'SlideController@sendGoods');
//
//
//// ROC Design 작업 테스트 route
//Route::get('/design/login', 'DesignTestController@login');
//Route::get('/design/register', 'DesignTestController@register');
//Route::get('/design/register_complete', 'DesignTestController@registerComplete');
//Route::get('/design/find_id', 'DesignTestController@findId');
//Route::get('/design/support', 'DesignTestController@support');
//
//
//
//
////notice 작업용 테스트 라우터 삭제 ㄴㄴ RE: ㅇㅇㅇ 삭제안할거임
//Route::get('/notice/{lecture_id}', 'ClassesController@noticePageTest');
//Route::post('/notice/{lecture_id}/page={page}', 'ClassesController@getNotice');

