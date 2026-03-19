import LmsLayout from '@/Layouts/LmsLayout';
import { Head, useForm } from '@inertiajs/react';

export default function AdmissionCreate({ auth, courses, batches }) {
    const { data, setData, post, processing, errors } = useForm({
        full_name: auth?.user?.name || '',
        email: auth?.user?.email || '',
        phone: '',
        course_id: '',
        batch_id: '',
        address: '',
        previous_education: '',
    });

    const allCourses = courses || [
        { id: 1, title: 'Full Stack Web Development' },
        { id: 2, title: 'Data Science & ML' },
        { id: 3, title: 'UI/UX Design' },
    ];

    const allBatches = batches || [
        { id: 1, name: 'Batch A – Morning (June 2026)', course_id: 1 },
        { id: 2, name: 'Batch B – Evening (June 2026)', course_id: 1 },
        { id: 3, name: 'Batch A – Morning (June 2026)', course_id: 2 },
    ];

    const filteredBatches = data.course_id
        ? allBatches.filter(b => b.course_id === parseInt(data.course_id))
        : allBatches;

    const submit = (e) => { e.preventDefault(); post(route('admissions.store')); };

    const card = { background: '#fff', borderRadius: '8px', boxShadow: '0 1px 3px rgba(0,0,0,0.08)', padding: '24px', marginBottom: '16px' };
    const label = { display: 'block', fontSize: '13px', fontWeight: 500, color: '#374151', marginBottom: '6px' };
    const input = { width: '100%', padding: '9px 12px', border: '1px solid #d1d5db', borderRadius: '6px', fontSize: '14px', color: '#1f2937', outline: 'none', boxSizing: 'border-box', background: '#fff' };

    return (
        <LmsLayout title="Apply for Admission">
            <Head title="Apply for Admission" />
            <div className="row justify-content-center">
                <div className="col-12 col-lg-8">
                    <div style={{ marginBottom: '20px' }}>
                        <h2 style={{ color: '#1f2937', fontSize: '20px', fontWeight: 700, margin: 0 }}>Apply for Admission</h2>
                        <p style={{ color: '#6b7280', fontSize: '13px', margin: '4px 0 0 0' }}>Fill in your details to begin your learning journey</p>
                    </div>

                    {/* Steps indicator */}
                    <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '20px' }}>
                        {['Personal Info', 'Course Selection', 'Submit'].map((step, i) => (
                            <div key={step} style={{ display: 'flex', alignItems: 'center', gap: '8px', flex: i < 2 ? 1 : 'none' }}>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '6px', whiteSpace: 'nowrap' }}>
                                    <div style={{ width: '26px', height: '26px', borderRadius: '50%', background: i === 0 ? '#2563eb' : '#e5e7eb', color: i === 0 ? '#fff' : '#9ca3af', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '12px', fontWeight: 600 }}>{i + 1}</div>
                                    <span style={{ fontSize: '13px', color: i === 0 ? '#1f2937' : '#9ca3af' }}>{step}</span>
                                </div>
                                {i < 2 && <div style={{ flex: 1, height: '1px', background: '#e5e7eb' }}></div>}
                            </div>
                        ))}
                    </div>

                    <form onSubmit={submit}>
                        {/* Personal Info */}
                        <div style={card}>
                            <h3 style={{ color: '#1f2937', fontSize: '15px', fontWeight: 700, marginBottom: '16px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                                <i className="bi bi-person-circle" style={{ color: '#2563eb' }}></i> Personal Information
                            </h3>
                            <div className="row g-3">
                                <div className="col-12 col-md-6">
                                    <label style={label}>Full Name *</label>
                                    <input value={data.full_name} onChange={e => setData('full_name', e.target.value)} required style={input} placeholder="Enter your full name"
                                        onFocus={e => e.target.style.borderColor = '#3b82f6'} onBlur={e => e.target.style.borderColor = '#d1d5db'} />
                                    {errors.full_name && <p style={{ color: '#ef4444', fontSize: '12px', margin: '4px 0 0' }}>{errors.full_name}</p>}
                                </div>
                                <div className="col-12 col-md-6">
                                    <label style={label}>Email Address *</label>
                                    <input type="email" value={data.email} onChange={e => setData('email', e.target.value)} required style={input} placeholder="you@email.com"
                                        onFocus={e => e.target.style.borderColor = '#3b82f6'} onBlur={e => e.target.style.borderColor = '#d1d5db'} />
                                    {errors.email && <p style={{ color: '#ef4444', fontSize: '12px', margin: '4px 0 0' }}>{errors.email}</p>}
                                </div>
                                <div className="col-12 col-md-6">
                                    <label style={label}>Phone Number *</label>
                                    <input type="tel" value={data.phone} onChange={e => setData('phone', e.target.value)} required style={input} placeholder="+91 98765 43210"
                                        onFocus={e => e.target.style.borderColor = '#3b82f6'} onBlur={e => e.target.style.borderColor = '#d1d5db'} />
                                    {errors.phone && <p style={{ color: '#ef4444', fontSize: '12px', margin: '4px 0 0' }}>{errors.phone}</p>}
                                </div>
                                <div className="col-12 col-md-6">
                                    <label style={label}>Previous Education</label>
                                    <input value={data.previous_education} onChange={e => setData('previous_education', e.target.value)} style={input} placeholder="e.g., B.Sc Computer Science"
                                        onFocus={e => e.target.style.borderColor = '#3b82f6'} onBlur={e => e.target.style.borderColor = '#d1d5db'} />
                                </div>
                                <div className="col-12">
                                    <label style={label}>Address</label>
                                    <textarea value={data.address} onChange={e => setData('address', e.target.value)} rows={3} style={{ ...input, resize: 'none' }} placeholder="Your current address"
                                        onFocus={e => e.target.style.borderColor = '#3b82f6'} onBlur={e => e.target.style.borderColor = '#d1d5db'}></textarea>
                                </div>
                            </div>
                        </div>

                        {/* Course Selection */}
                        <div style={card}>
                            <h3 style={{ color: '#1f2937', fontSize: '15px', fontWeight: 700, marginBottom: '16px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                                <i className="bi bi-collection-play" style={{ color: '#2563eb' }}></i> Course Selection
                            </h3>
                            <div className="row g-3">
                                <div className="col-12">
                                    <label style={label}>Select Course *</label>
                                    <select value={data.course_id} onChange={e => { setData('course_id', e.target.value); setData('batch_id', ''); }} required style={{ ...input, cursor: 'pointer' }}
                                        onFocus={e => e.target.style.borderColor = '#3b82f6'} onBlur={e => e.target.style.borderColor = '#d1d5db'}>
                                        <option value="">-- Choose a Course --</option>
                                        {allCourses.map(c => <option key={c.id} value={c.id}>{c.title}</option>)}
                                    </select>
                                    {errors.course_id && <p style={{ color: '#ef4444', fontSize: '12px', margin: '4px 0 0' }}>{errors.course_id}</p>}
                                </div>
                                <div className="col-12">
                                    <label style={label}>Select Batch *</label>
                                    <select value={data.batch_id} onChange={e => setData('batch_id', e.target.value)} required style={{ ...input, cursor: 'pointer' }}
                                        onFocus={e => e.target.style.borderColor = '#3b82f6'} onBlur={e => e.target.style.borderColor = '#d1d5db'}>
                                        <option value="">-- Choose a Batch --</option>
                                        {filteredBatches.map(b => <option key={b.id} value={b.id}>{b.name}</option>)}
                                    </select>
                                    {errors.batch_id && <p style={{ color: '#ef4444', fontSize: '12px', margin: '4px 0 0' }}>{errors.batch_id}</p>}
                                </div>
                            </div>
                        </div>

                        {/* Submit */}
                        <div style={{ display: 'flex', justifyContent: 'flex-end' }}>
                            <button type="submit" disabled={processing} style={{
                                padding: '11px 28px', background: processing ? '#93c5fd' : '#2563eb', color: '#fff',
                                border: 'none', borderRadius: '6px', fontSize: '14px', fontWeight: 600,
                                cursor: processing ? 'not-allowed' : 'pointer', transition: 'background 0.15s',
                            }}>
                                {processing ? 'Submitting...' : 'Submit Application'}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </LmsLayout>
    );
}
