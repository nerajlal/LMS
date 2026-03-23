import { useState } from 'react';
import LmsLayout from '@/Layouts/LmsLayout';
import { Head, useForm, router } from '@inertiajs/react';

export default function TrainerCourseShow({ course }) {
    const { data: lessonData, setData: setLessonData, post: postLesson, processing: lessonProcessing, reset: resetLesson, errors: lessonErrors } = useForm({
        title: '',
        video_url: '',
    });

    const { data: materialData, setData: setMaterialData, post: postMaterial, processing: materialProcessing, reset: resetMaterial, errors: materialErrors } = useForm({
        title: '',
        file: null,
    });

    const [activeTab, setActiveTab] = useState('lessons');

    const submitLesson = (e) => {
        e.preventDefault();
        postLesson(route('trainer.courses.lessons.store', course.id), {
            preserveScroll: true,
            onSuccess: () => resetLesson(),
        });
    };

    const submitMaterial = (e) => {
        e.preventDefault();
        postMaterial(route('trainer.courses.materials.store', course.id), {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => resetMaterial(),
        });
    };

    return (
        <LmsLayout title={course.title}>
            <Head title={`Manage: ${course.title} - Trainer`} />
            
            <div className="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 style={{ fontSize: '24px', fontWeight: 800, color: '#1e293b', margin: 0 }}>{course.title}</h1>
                    <div style={{ color: '#64748b', fontSize: '14px', marginTop: '4px' }}>Course Management Dashboard</div>
                </div>
            </div>

            <div style={{ display: 'flex', gap: '2px', background: '#e2e8f0', padding: '4px', borderRadius: '12px', width: 'fit-content', marginBottom: '24px' }}>
                <button 
                    onClick={() => setActiveTab('lessons')}
                    style={{ background: activeTab === 'lessons' ? '#fff' : 'transparent', color: activeTab === 'lessons' ? '#e3000f' : '#64748b', border: 'none', padding: '10px 24px', borderRadius: '8px', fontWeight: 600, fontSize: '14px', cursor: 'pointer', transition: 'all 0.2s', boxShadow: activeTab === 'lessons' ? '0 1px 3px rgba(0,0,0,0.1)' : 'none' }}
                >
                    <i className="bi bi-play-circle me-2"></i> YouTube Lessons
                </button>
                <button 
                    onClick={() => setActiveTab('materials')}
                    style={{ background: activeTab === 'materials' ? '#fff' : 'transparent', color: activeTab === 'materials' ? '#e3000f' : '#64748b', border: 'none', padding: '10px 24px', borderRadius: '8px', fontWeight: 600, fontSize: '14px', cursor: 'pointer', transition: 'all 0.2s', boxShadow: activeTab === 'materials' ? '0 1px 3px rgba(0,0,0,0.1)' : 'none' }}
                >
                    <i className="bi bi-file-earmark-pdf me-2"></i> PDF Materials
                </button>
            </div>

            <div className="row g-4">
                <div className="col-12 col-lg-8">
                    {/* LIST SECTION */}
                    <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', padding: '24px' }}>
                        <h2 style={{ fontSize: '18px', fontWeight: 700, color: '#1e293b', marginBottom: '24px' }}>
                            {activeTab === 'lessons' ? 'Current Video Lessons' : 'Current Study Materials'}
                        </h2>

                        {activeTab === 'lessons' ? (
                            course.lessons && course.lessons.length > 0 ? (
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
                                    {course.lessons.map((lesson, idx) => (
                                        <div key={lesson.id} style={{ display: 'flex', alignItems: 'center', gap: '16px', padding: '16px', border: '1px solid #f1f5f9', borderRadius: '8px' }}>
                                            <div style={{ width: '32px', height: '32px', borderRadius: '50%', background: '#fef2f2', color: '#e3000f', display: 'flex', alignItems: 'center', justifyContent: 'center', fontWeight: 700, fontSize: '14px' }}>
                                                {idx + 1}
                                            </div>
                                            <div style={{ flex: 1 }}>
                                                <div style={{ fontWeight: 600, color: '#1e293b' }}>{lesson.title}</div>
                                                <div style={{ fontSize: '12px', color: '#64748b', marginTop: '4px' }}>{lesson.video_url}</div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div style={{ textAlign: 'center', padding: '40px 20px', color: '#64748b', background: '#f8fafc', borderRadius: '8px' }}>
                                    <i className="bi bi-camera-video" style={{ fontSize: '24px', color: '#cbd5e1', display: 'block', marginBottom: '8px' }}></i>
                                    No recorded lessons uploaded yet.
                                </div>
                            )
                        ) : (
                            course.study_materials && course.study_materials.length > 0 ? (
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
                                    {course.study_materials.map((mat) => (
                                        <div key={mat.id} style={{ display: 'flex', alignItems: 'center', gap: '16px', padding: '16px', border: '1px solid #f1f5f9', borderRadius: '8px' }}>
                                            <div style={{ width: '40px', height: '40px', borderRadius: '8px', background: '#fef2f2', color: '#e3000f', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '18px' }}>
                                                <i className="bi bi-file-earmark-pdf-fill"></i>
                                            </div>
                                            <div style={{ flex: 1 }}>
                                                <div style={{ fontWeight: 600, color: '#1e293b' }}>{mat.title}</div>
                                                <div style={{ fontSize: '12px', color: '#64748b', marginTop: '4px' }}>
                                                    {mat.file_type ? mat.file_type.toUpperCase() : 'PDF'} • {(mat.file_size / 1024 / 1024).toFixed(2)} MB
                                                </div>
                                            </div>
                                            <a href={mat.file_path} target="_blank" rel="noreferrer" className="btn btn-sm" style={{ background: '#f8fafc', color: '#475569', border: '1px solid #e2e8f0' }}>
                                                View
                                            </a>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div style={{ textAlign: 'center', padding: '40px 20px', color: '#64748b', background: '#f8fafc', borderRadius: '8px' }}>
                                    <i className="bi bi-file-earmark-text" style={{ fontSize: '24px', color: '#cbd5e1', display: 'block', marginBottom: '8px' }}></i>
                                    No study materials uploaded yet.
                                </div>
                            )
                        )}
                    </div>
                </div>

                <div className="col-12 col-lg-4">
                    {/* ADD FORM SECTION */}
                    <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', padding: '24px', position: 'sticky', top: '100px' }}>
                        <h2 style={{ fontSize: '16px', fontWeight: 700, color: '#1e293b', marginBottom: '20px' }}>
                            {activeTab === 'lessons' ? 'Add New YouTube Lesson' : 'Upload New Material'}
                        </h2>

                        {activeTab === 'lessons' ? (
                            <form onSubmit={submitLesson}>
                                <div className="mb-3">
                                    <label style={{ fontSize: '13px', fontWeight: 600, color: '#475569', marginBottom: '6px', display: 'block' }}>Lesson Title</label>
                                    <input 
                                        type="text" 
                                        className="form-control" 
                                        value={lessonData.title} 
                                        onChange={e => setLessonData('title', e.target.value)} 
                                        placeholder="e.g. Introduction to React"
                                        style={{ background: '#f8fafc', border: '1px solid #e2e8f0', borderRadius: '8px', padding: '10px 14px', fontSize: '14px' }}
                                    />
                                    {lessonErrors.title && <div style={{ color: '#e3000f', fontSize: '12px', marginTop: '4px' }}>{lessonErrors.title}</div>}
                                </div>
                                <div className="mb-4">
                                    <label style={{ fontSize: '13px', fontWeight: 600, color: '#475569', marginBottom: '6px', display: 'block' }}>YouTube Embed URL</label>
                                    <input 
                                        type="url" 
                                        className="form-control" 
                                        value={lessonData.video_url} 
                                        onChange={e => setLessonData('video_url', e.target.value)} 
                                        placeholder="https://www.youtube.com/embed/..."
                                        style={{ background: '#f8fafc', border: '1px solid #e2e8f0', borderRadius: '8px', padding: '10px 14px', fontSize: '14px' }}
                                    />
                                    {lessonErrors.video_url && <div style={{ color: '#e3000f', fontSize: '12px', marginTop: '4px' }}>{lessonErrors.video_url}</div>}
                                </div>
                                <button type="submit" disabled={lessonProcessing} style={{ width: '100%', background: '#1e293b', color: '#fff', border: 'none', padding: '12px', borderRadius: '8px', fontWeight: 600, transition: 'all 0.2s', opacity: lessonProcessing ? 0.7 : 1 }}>
                                    {lessonProcessing ? 'Adding...' : 'Add Lesson to Course'}
                                </button>
                            </form>
                        ) : (
                            <form onSubmit={submitMaterial}>
                                <div className="mb-3">
                                    <label style={{ fontSize: '13px', fontWeight: 600, color: '#475569', marginBottom: '6px', display: 'block' }}>Material Title</label>
                                    <input 
                                        type="text" 
                                        className="form-control" 
                                        value={materialData.title} 
                                        onChange={e => setMaterialData('title', e.target.value)} 
                                        placeholder="e.g. Chapter 1 Handout"
                                        style={{ background: '#f8fafc', border: '1px solid #e2e8f0', borderRadius: '8px', padding: '10px 14px', fontSize: '14px' }}
                                    />
                                    {materialErrors.title && <div style={{ color: '#e3000f', fontSize: '12px', marginTop: '4px' }}>{materialErrors.title}</div>}
                                </div>
                                <div className="mb-4">
                                    <label style={{ fontSize: '13px', fontWeight: 600, color: '#475569', marginBottom: '6px', display: 'block' }}>PDF / Document File</label>
                                    <input 
                                        type="file" 
                                        className="form-control" 
                                        onChange={e => setMaterialData('file', e.target.files[0])} 
                                        accept=".pdf,.doc,.docx,.zip"
                                        style={{ background: '#f8fafc', border: '1px solid #e2e8f0', borderRadius: '8px', padding: '8px 14px', fontSize: '14px' }}
                                    />
                                    {materialErrors.file && <div style={{ color: '#e3000f', fontSize: '12px', marginTop: '4px' }}>{materialErrors.file}</div>}
                                </div>
                                <button type="submit" disabled={materialProcessing} style={{ width: '100%', background: '#e3000f', color: '#fff', border: 'none', padding: '12px', borderRadius: '8px', fontWeight: 600, transition: 'all 0.2s', opacity: materialProcessing ? 0.7 : 1 }}>
                                    {materialProcessing ? 'Uploading...' : 'Upload Study Material'}
                                </button>
                            </form>
                        )}
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
