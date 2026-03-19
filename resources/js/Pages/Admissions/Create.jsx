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
        { id: 1, name: 'Batch A - Morning (June 2026)', course_id: 1 },
        { id: 2, name: 'Batch B - Evening (June 2026)', course_id: 1 },
        { id: 3, name: 'Batch A - Morning (June 2026)', course_id: 2 },
    ];

    const filteredBatches = data.course_id
        ? allBatches.filter(b => b.course_id === parseInt(data.course_id))
        : allBatches;

    const submit = (e) => {
        e.preventDefault();
        post(route('admissions.store'));
    };

    const inputStyle = {
        width: '100%', background: 'rgba(255,255,255,0.07)', border: '1px solid rgba(255,255,255,0.12)',
        borderRadius: '10px', color: '#fff', padding: '12px 14px', fontSize: '14px', outline: 'none',
    };
    const labelStyle = { color: 'rgba(255,255,255,0.7)', fontSize: '13px', fontWeight: 500, marginBottom: '6px', display: 'block' };
    const errorStyle = { color: '#ef4444', fontSize: '12px', marginTop: '4px' };

    return (
        <LmsLayout>
            <Head title="Apply for Admission" />

            <div className="row justify-content-center">
                <div className="col-12 col-lg-8">
                    {/* Header */}
                    <div style={{ marginBottom: '28px' }}>
                        <h1 style={{ color: '#fff', fontSize: '24px', fontWeight: 700, margin: 0 }}>Apply for Admission</h1>
                        <p style={{ color: 'rgba(255,255,255,0.5)', fontSize: '14px', margin: '6px 0 0 0' }}>Fill in your details to begin your learning journey</p>
                    </div>

                    {/* Progress Steps */}
                    <div className="d-flex align-items-center gap-2 mb-4">
                        {['Personal Info', 'Course Selection', 'Review'].map((step, i) => (
                            <div key={step} className="d-flex align-items-center gap-2" style={{ flex: i < 2 ? '1' : 'none' }}>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '8px', whiteSpace: 'nowrap' }}>
                                    <div style={{
                                        width: '28px', height: '28px', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '12px', fontWeight: 700,
                                        background: i === 0 ? 'linear-gradient(135deg, #7c3aed, #4f46e5)' : 'rgba(255,255,255,0.08)',
                                        color: i === 0 ? '#fff' : 'rgba(255,255,255,0.4)',
                                    }}>{i + 1}</div>
                                    <span style={{ color: i === 0 ? '#fff' : 'rgba(255,255,255,0.4)', fontSize: '13px' }}>{step}</span>
                                </div>
                                {i < 2 && <div style={{ flex: 1, height: '1px', background: 'rgba(255,255,255,0.1)', marginLeft: '4px' }}></div>}
                            </div>
                        ))}
                    </div>

                    {/* Form */}
                    <form onSubmit={submit}>
                        {/* Personal Info Section */}
                        <div style={{ background: 'rgba(255,255,255,0.04)', border: '1px solid rgba(255,255,255,0.08)', borderRadius: '16px', padding: '24px', marginBottom: '20px' }}>
                            <h2 style={{ color: '#fff', fontSize: '16px', fontWeight: 700, marginBottom: '20px' }}>
                                <i className="bi bi-person-circle me-2" style={{ color: '#7c3aed' }}></i> Personal Information
                            </h2>
                            <div className="row g-3">
                                <div className="col-12 col-md-6">
                                    <label style={labelStyle}>Full Name *</label>
                                    <input value={data.full_name} onChange={e => setData('full_name', e.target.value)} required style={inputStyle} placeholder="Enter your full name" />
                                    {errors.full_name && <div style={errorStyle}>{errors.full_name}</div>}
                                </div>
                                <div className="col-12 col-md-6">
                                    <label style={labelStyle}>Email Address *</label>
                                    <input type="email" value={data.email} onChange={e => setData('email', e.target.value)} required style={inputStyle} placeholder="your@email.com" />
                                    {errors.email && <div style={errorStyle}>{errors.email}</div>}
                                </div>
                                <div className="col-12 col-md-6">
                                    <label style={labelStyle}>Phone Number *</label>
                                    <input type="tel" value={data.phone} onChange={e => setData('phone', e.target.value)} required style={inputStyle} placeholder="+91 98765 43210" />
                                    {errors.phone && <div style={errorStyle}>{errors.phone}</div>}
                                </div>
                                <div className="col-12 col-md-6">
                                    <label style={labelStyle}>Previous Education</label>
                                    <input value={data.previous_education} onChange={e => setData('previous_education', e.target.value)} style={inputStyle} placeholder="e.g., B.Sc Computer Science" />
                                </div>
                                <div className="col-12">
                                    <label style={labelStyle}>Address</label>
                                    <textarea value={data.address} onChange={e => setData('address', e.target.value)} rows={3} style={{ ...inputStyle, resize: 'none' }} placeholder="Your current address"></textarea>
                                </div>
                            </div>
                        </div>

                        {/* Course Selection */}
                        <div style={{ background: 'rgba(255,255,255,0.04)', border: '1px solid rgba(255,255,255,0.08)', borderRadius: '16px', padding: '24px', marginBottom: '20px' }}>
                            <h2 style={{ color: '#fff', fontSize: '16px', fontWeight: 700, marginBottom: '20px' }}>
                                <i className="bi bi-collection-play me-2" style={{ color: '#7c3aed' }}></i> Course Selection
                            </h2>
                            <div className="row g-3">
                                <div className="col-12">
                                    <label style={labelStyle}>Select Course *</label>
                                    <select
                                        value={data.course_id}
                                        onChange={e => { setData('course_id', e.target.value); setData('batch_id', ''); }}
                                        required
                                        style={{ ...inputStyle, cursor: 'pointer' }}
                                    >
                                        <option value="" style={{ background: '#1a1d2e' }}>-- Choose a Course --</option>
                                        {allCourses.map(c => (
                                            <option key={c.id} value={c.id} style={{ background: '#1a1d2e' }}>{c.title}</option>
                                        ))}
                                    </select>
                                    {errors.course_id && <div style={errorStyle}>{errors.course_id}</div>}
                                </div>
                                <div className="col-12">
                                    <label style={labelStyle}>Select Batch *</label>
                                    <select
                                        value={data.batch_id}
                                        onChange={e => setData('batch_id', e.target.value)}
                                        required
                                        style={{ ...inputStyle, cursor: 'pointer' }}
                                    >
                                        <option value="" style={{ background: '#1a1d2e' }}>-- Choose a Batch --</option>
                                        {filteredBatches.map(b => (
                                            <option key={b.id} value={b.id} style={{ background: '#1a1d2e' }}>{b.name}</option>
                                        ))}
                                    </select>
                                    {errors.batch_id && <div style={errorStyle}>{errors.batch_id}</div>}
                                </div>
                            </div>
                        </div>

                        {/* Submit */}
                        <div className="d-flex justify-content-end">
                            <button
                                type="submit"
                                disabled={processing}
                                style={{
                                    padding: '13px 32px', background: 'linear-gradient(90deg, #7c3aed, #4f46e5)',
                                    color: '#fff', border: 'none', borderRadius: '12px', fontSize: '15px', fontWeight: 700, cursor: processing ? 'not-allowed' : 'pointer',
                                    opacity: processing ? 0.7 : 1, transition: 'opacity 0.2s',
                                }}
                            >
                                {processing ? 'Submitting...' : 'Submit Application'}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </LmsLayout>
    );
}
