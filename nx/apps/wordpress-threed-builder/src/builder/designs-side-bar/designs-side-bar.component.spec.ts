import { ComponentFixture, TestBed } from '@angular/core/testing';
import { DesignsSideBarComponent } from './designs-side-bar.component';

describe('DesignsSideBarComponent', () => {
  let component: DesignsSideBarComponent;
  let fixture: ComponentFixture<DesignsSideBarComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DesignsSideBarComponent],
    }).compileComponents();

    fixture = TestBed.createComponent(DesignsSideBarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
