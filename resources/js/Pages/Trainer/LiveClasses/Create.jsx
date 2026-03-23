import LmsLayout from '@/Layouts/LmsLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function TrainerLiveClassCreate({ courses }) {
    const { data, setData, post, processing, errors } = useForm({
        course_id: '',
        title: '',
        start_time: '',
        duration: '60 minutes',
        zoom_link: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('trainer.live-classes.store'));
    };

    return (
        <LmsLayout title="Schedule Live Class">
            <Head title="Schedule Class - Trainer" />

            <div className="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 style={{ fontSize: '24px', fontWeight: 800, color: '#1e293b', margin: 0 }}>Schedule Live Class</h1>
                    <div style={{ color: '#64748b', fontSize: '14px', marginTop: '4px' }}>Set up a new Zoom meeting for your students</div>
                </div>
                <Link href={route('trainer.live-classes.index')} className="btn" style={{ background: '#f8fafc', color: '#475569', border: '1px solid #e2e8f0', fontWeight: 600 }}>
                    Cancel
                </Link>
            </div>

            <div style={{ background: '#fff', borderRadius: '12px', border: '1px solid #f1f5f9', padding: '32px', maxWidth: '800px' }}>
                <form onSubmit={submit}>
                    <div className="row g-4 mb-4">
                        <div className="col-12 col-md-6">
                            <label style={{ fontSize: '13px', fontWeight: 600, color: '#475569', marginBottom: '8px', display: 'block' }}>Related Course <span style={{ color: '#94a3b8', fontWeight: 400 }}>(Optional)</span></label>
                            <select 
                                className="form-select" 
                                value={data.course_id} 
                                onChange={e => setData('course_id', e.target.value)}
                                style={{ background: '#f8fafc', border: '1px solid #e2e8f0', borderRadius: '8px', padding: '12px 14px', fontSize: '14px' }}
                            >
                                <option value="">General Class (No specific course)</option>
                                {courses.map(course => (
                                    <option key={course.id} value={course.id}>{course.title}</option>
                                ))}
                            </select>
                            {errors.course_id && <div style={{ color: '#e3000f', fontSize: '12px', marginTop: '4px' }}>{errors.course_id}</div>}
                        </div>

                        <div className="col-12 col-md-6">
                            <label style={{ fontSize: '13px', fontWeight: 600, color: '#475569', marginBottom: '8px', display: 'block' }}>Class Topic / Title</label>
                            <input 
                                type="text" 
                                className="form-control" 
                                value={data.title} 
                                onChange={e => setData('title', e.target.value)} 
                                placeholder="e.g. Q&A Session for Week 1"
                                style={{ background: '#f8fafc', border: '1px solid #e2e8f0', borderRadius: '8px', padding: '12px 14px', fontSize: '14px' }}
                            />
                            {errors.title && <div style={{ color: '#e3000f', fontSize: '12px', marginTop: '4px' }}>{errors.title}</div>}
                        </div>
                    </div>

                    <div className="row g-4 mb-4">
                        <div className="col-12 col-md-4">
                            <label style={{ fontSize: '13px', fontWeight: 600, color: '#475569', marginBottom: '8px', display: 'block' }}>Start Date & Time</label>
                            <input 
                                type="datetime-local" 
                                className="form-control" 
                                value={data.start_time} 
                                onChange={e => setData('start_time', e.target.value)} 
                                style={{ background: '#f8fafc', border: '1px solid #e2e8f0', borderRadius: '8px', padding: '12px 14px', fontSize: '14px' }}
                            />
                            {errors.start_time && <div style={{ color: '#e3000f', fontSize: '12px', marginTop: '4px' }}>{errors.start_time}</div>}
                        </div>

                        <div className="col-12 col-md-8">
                            <label style={{ fontSize: '13px', fontWeight: 600, color: '#475569', marginBottom: '8px', display: 'block' }}>Estimated Duration</label>
                            <input 
                                type="text" 
                                className="form-control" 
                                value={data.duration} 
                                onChange={e => setData('duration', e.target.value)} 
                                placeholder="e.g. 60 minutes"
                                style={{ background: '#f8fafc', border: '1px solid #e2e8f0', borderRadius: '8px', padding: '12px 14px', fontSize: '14px' }}
                            />
                            {errors.duration && <div style={{ color: '#e3000f', fontSize: '12px', marginTop: '4px' }}>{errors.duration}</div>}
                        </div>
                    </div>

                    <div className="mb-5">
                        <label style={{ fontSize: '13px', fontWeight: 600, color: '#475569', marginBottom: '8px', display: 'block' }}>Meeting Link (Zoom, Meet, etc)</label>
                        <input 
                            type="url" 
                            className="form-control" 
                            value={data.zoom_link} 
                            onChange={e => setData('zoom_link', e.target.value)} 
                            placeholder="https://us04web.zoom.us/j/..."
                            style={{ background: '#f8fafc', border: '1px solid #e2e8f0', borderRadius: '8px', padding: '12px 14px', fontSize: '14px' }}
                        />
                        {errors.zoom_link && <div style={{ color: '#e3000f', fontSize: '12px', marginTop: '4px' }}>{errors.zoom_link}</div>}
                        <div style={{ fontSize: '12px', color: '#94a3b8', marginTop: '6px' }}>Provide the full URL that students will use to join the remote meeting.</div>
                    </div>

                    <div style={{ display: 'flex', justifyContent: 'flex-end', gap: '16px', borderTop: '1px solid #f1f5f9', paddingTop: '24px' }}>
                        <Link href={route('trainer.live-classes.index')} className="btn" style={{ background: 'transparent', color: '#64748b', fontWeight: 600, padding: '10px 24px' }}>
                            Cancel
                        </Link>
                        <button type="submit" disabled={processing} className="btn" style={{ background: '#e3000f', color: '#fff', fontWeight: 600, padding: '10px 24px', borderRadius: '8px', minWidth: '160px' }}>
                            {processing ? 'Scheduling...' : 'Schedule Live Class'}
                        </button>
                    </div>
                </form>
            </div>
        </LmsLayout>
    );
}
