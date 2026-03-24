import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm, Link } from '@inertiajs/react';

export default function AdminTrainersCreate() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('admin.trainers.store'));
    };

    return (
        <AdminLayout title="Add Trainer">
            <Head title="Admin — Add Trainer" />

            <div style={{ marginBottom: '20px', display: 'flex', alignItems: 'center', gap: '12px' }}>
                <Link href={route('admin.trainers.index')} style={{ color: '#6b7280', textDecoration: 'none', fontSize: '14px' }}>
                    <i className="bi bi-arrow-left"></i> Back to Trainers
                </Link>
            </div>

            <div style={{ background: '#fff', borderRadius: '12px', boxShadow: '0 1px 4px rgba(0,0,0,0.08)', maxWidth: '600px', padding: '32px' }}>
                <h2 style={{ margin: '0 0 24px 0', fontSize: '18px', fontWeight: 700, color: '#1f2937' }}>New Trainer Details</h2>
                
                <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
                    
                    {/* Name */}
                    <div>
                        <label style={{ display: 'block', marginBottom: '8px', fontSize: '14px', fontWeight: 600, color: '#374151' }}>Full Name</label>
                        <input 
                            type="text" 
                            name="name"
                            value={data.name} 
                            onChange={e => setData('name', e.target.value)} 
                            style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid #d1d5db', fontSize: '14px' }} 
                            placeholder="John Doe"
                            required
                        />
                        {errors.name && <div style={{ color: '#F37021', fontSize: '12px', marginTop: '6px' }}>{errors.name}</div>}
                    </div>

                    {/* Email */}
                    <div>
                        <label style={{ display: 'block', marginBottom: '8px', fontSize: '14px', fontWeight: 600, color: '#374151' }}>Email Address</label>
                        <input 
                            type="email" 
                            name="email"
                            value={data.email} 
                            onChange={e => setData('email', e.target.value)} 
                            style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid #d1d5db', fontSize: '14px' }}
                            placeholder="trainer@example.com"
                            required
                        />
                        {errors.email && <div style={{ color: '#F37021', fontSize: '12px', marginTop: '6px' }}>{errors.email}</div>}
                    </div>

                    {/* Password */}
                    <div>
                        <label style={{ display: 'block', marginBottom: '8px', fontSize: '14px', fontWeight: 600, color: '#374151' }}>Password</label>
                        <input 
                            type="password" 
                            name="password"
                            value={data.password} 
                            onChange={e => setData('password', e.target.value)} 
                            style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid #d1d5db', fontSize: '14px' }}
                            required
                        />
                        {errors.password && <div style={{ color: '#F37021', fontSize: '12px', marginTop: '6px' }}>{errors.password}</div>}
                    </div>

                    {/* Password Confirmation */}
                    <div>
                        <label style={{ display: 'block', marginBottom: '8px', fontSize: '14px', fontWeight: 600, color: '#374151' }}>Confirm Password</label>
                        <input 
                            type="password" 
                            name="password_confirmation"
                            value={data.password_confirmation} 
                            onChange={e => setData('password_confirmation', e.target.value)} 
                            style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid #d1d5db', fontSize: '14px' }}
                            required
                        />
                    </div>

                    <hr style={{ borderTop: '1px solid #e5e7eb', margin: '24px 0 4px 0' }} />

                    <div style={{ display: 'flex', justifyContent: 'flex-end', gap: '12px' }}>
                        <Link 
                            href={route('admin.trainers.index')} 
                            style={{ padding: '10px 20px', borderRadius: '8px', border: '1px solid #d1d5db', color: '#374151', textDecoration: 'none', fontSize: '14px', fontWeight: 600 }}
                        >
                            Cancel
                        </Link>
                        <button 
                            type="submit" 
                            disabled={processing}
                            style={{
                                background: 'linear-gradient(to right, #F37021, #1B365D)',
                                color: '#fff', border: 'none', padding: '10px 24px', borderRadius: '8px',
                                fontSize: '14px', fontWeight: 600, cursor: processing ? 'not-allowed' : 'pointer',
                                opacity: processing ? 0.7 : 1
                            }}
                        >
                            {processing ? 'Saving...' : 'Create Trainer'}
                        </button>
                    </div>

                </form>
            </div>
        </AdminLayout>
    );
}
