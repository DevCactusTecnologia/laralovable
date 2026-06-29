<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment\Appointment;
use App\Models\Biomedical;
use App\Models\State;
use App\Helpers\Pagination;
use App\Models\ClassCouncil;
use App\Http\Requests\BiomedicalRequest;
use App\Models\ProfessionalType;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class BiomedicalController extends Controller
{
    public function index(): View
    {
        $biomedicalRole = Sentinel::findRoleBySlug('biomedical');
        $biomedicals = $biomedicalRole->users()
            ->with(['roles'])
            ->orderByDesc('id')
            ->get();

        return view('biomedicals.index', 
            compact('biomedicals')
        );
    }

    public function create(): View
    {
        return view('biomedicals.create', [
            'classCouncils' => ClassCouncil::all(),
            'states' => State::all(),
            'professionals' => ProfessionalType::active()->get(),
        ]);
    }

    public function store(BiomedicalRequest $request): RedirectResponse
    {  
        try {
            $request->merge(['profile_photo' => Biomedical::saveProfileImage($request)]);
            $request->merge(['signature' => Biomedical::saveSignatureImage($request)]);

            $userId = User::createUserBiomedical($request);
            Biomedical::create($request->all() + ['user_id' => $userId]);
            session()->put('success', $request->message);
            
            return redirect()->route('biomedicals.index');
        } catch (\Exception $error) {
            return redirect()
                ->route('biomedicals.index')
                ->withError('Algo deu errado! ' . $error->getMessage());
        }
    }

    public function show(User $biomedical): View
    {
        $biomedical = User::findByBiomedicalId($biomedical->id);
        $limit = Pagination::getLimit();
        $data = Appointment::totalByBiomedical($biomedical->id);
        $appointments = Appointment::byBiomedicalId($biomedical->id, $limit);
            
        return view('biomedicals.show', 
            compact('biomedical', 'data', 'appointments', 'limit')
        );
    }

    public function edit(User $biomedical): View
    {
        return view('biomedicals.edit', [
            'biomedical' => User::findByBiomedicalId($biomedical->id),
            'biomedical_info' => Biomedical::firstWhere('user_id', $biomedical->id),
            'classCouncils' => ClassCouncil::all(),
            'states' => State::all(),
            'professionals' => ProfessionalType::active()->get(),
        ]);
    }

    public function update(BiomedicalRequest $request, User $biomedical): RedirectResponse
    {  
        try {
            $user = Sentinel::getUser();
            $role = $user->roles[0]->slug;

            Biomedical::updateDataToUser($biomedical, $request, $user->id);
            Biomedical::updateData($biomedical, $request);
            session()->put('success', $request->message);
                    
            if ($role == 'biomedical') {
                return redirect('/')->withSuccess('Perfil atualizado com sucesso!');
            }
                
            return redirect()->route('biomedicals.index');
        } catch (\Exception $error) {
            return redirect()
                ->route('biomedicals.index')
                ->withError('Algo deu errado! ' . $error->getMessage());
        }
    }

    public function search(): JsonResponse
    {
        return response()->json([
            'biomedicals' => Biomedical::getAll()
        ]);
    }
}
